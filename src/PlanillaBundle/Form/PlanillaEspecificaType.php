<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use PlanillaBundle\Entity\Especifica;

class PlanillaEspecificaType extends AbstractType {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('anoEje', ChoiceType::class, [
                    "label" => "Año de Origen",
                    "mapped" => false,
                    "required" => "required",
                    "choices" => $options['anoArray'],
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['anoEje']
                ])
                ->add('mesEje', EntityType::class, [
                    "label" => "Mes de Origen",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:Mes",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['mesEje']
                ])
                ->add('especifica', EntityType::class, [
                    "label" => "Específica de Gasto",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:Especifica",
                    "choices" => $options['especificas'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add($options['btnSubmit'], SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }
    
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        $em = $this->entityManager;
        $especifica = $em->getRepository('PlanillaBundle:Especifica')->findOneBy(["id" => $data['especifica']]);
        $this->seteandoEspecifica($form, $especifica);
    }
    
    protected function seteandoEspecifica(FormInterface $form, Especifica $especifica) {
        $form->add('fuente', EntityType::class, [
            "label" => "Específica de Gasto",
            "mapped" => false,
            "required" => "required",
            "class" => "PlanillaBundle:Especifica",
            "choice_label" => "nombre",
            "data" => $especifica
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Planilla',
            'anoArray' => null,
            'anoEje' => null,
            'mesEje' => null,
            'especificas' => null,
            'btnSubmit' => null
            ]);
    }

}

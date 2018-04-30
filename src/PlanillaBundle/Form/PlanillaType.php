<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use PlanillaBundle\Entity\TipoPlanilla;
use PlanillaBundle\Entity\PlazaHistorial;

class PlanillaType extends AbstractType {

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
                ->add('anoEje', NumberType::class, [
                    "label" => "Año",
                    "required" => "required",
                    "data" => $options['anoEje'],
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => true]
                ])
                ->add('mesEje', EntityType::class, [
                    "label" => "Mes",
                    "required" => "required",
                    "class" => "PlanillaBundle:Mes",
                    "choice_label" => "nombre",
                    "data" => $options['mesEje'],
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => true]
                ])
                ->add('tipoPlanilla', EntityType::class, [
                    "label" => "Tipo de Planilla",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoPlanilla",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('fuente', EntityType::class, [
                    "label" => "Fuente de Financiamiento",
                    "required" => "required",
                    "class" => "PlanillaBundle:FuenteFinanc",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                ->where('p.estado = 1');
                    },
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('plazaHistorial', EntityType::class, [
                    "label" => "Plaza de Personal",
                    "required" => "required",
                    "class" => "PlanillaBundle:PlazaHistorial",
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('nota', TextareaType::class, [
                    "label" => "Nota",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmitData'));
    }

    function onPreSetData(FormEvent $event) {
        $form = $event->getForm();
        $options = $form->getConfig()->getOptions();
        if ($options['accion'] == 1) {
            $em = $this->entityManager;
            $tipoPlanilla = $em->getRepository('PlanillaBundle:TipoPlanilla')->findOneBy(["id" => 1]);
            $this->seteandoPlazaHistorial($form, $tipoPlanilla, $options['anoEje'], $options['mesEje']);
        }
    }

    function onPreSubmitData(FormEvent $event) {
        $em = $this->entityManager;
        $form = $event->getForm();
        $data = $event->getData();
        $options = $form->getConfig()->getOptions();
        if ($options['accion'] == 1) {
            $plazaHistorial = $em->getRepository('PlanillaBundle:PlazaHistorial')->find($data['plazaHistorial']);
            $this->seteandoPlazaHistorialSubmit($form, $plazaHistorial);
        }
    }

    protected function seteandoPlazaHistorial(FormInterface $form, TipoPlanilla $tipoPlanilla, $anoEje, $mesEje) {
        $em = $this->entityManager;
        $plazaHistoriales = $em->getRepository('PlanillaBundle:PlazaHistorial')->findByTipoPlanillaAnoEjeMesEje($tipoPlanilla, $anoEje, $mesEje);

        $form->add('plazaHistorial', EntityType::class, [
            "label" => "Plaza de Personal",
            "required" => "required",
            "class" => "PlanillaBundle:PlazaHistorial",
            "choice_label" => "cadena",
            "choices" => $plazaHistoriales,
            "attr" => ["class" => "form-control form-control-sm"],
        ]);
    }

    protected function seteandoPlazaHistorialSubmit(FormInterface $form, PlazaHistorial $plazaHistorial) {
        $em = $this->entityManager;
        $plazaHistoriales = $em->getRepository('PlanillaBundle:PlazaHistorial')->findAll();

        $form->add('plazaHistorial', EntityType::class, [
            "label" => "Plaza de Personal",
            "required" => "required",
            "class" => "PlanillaBundle:PlazaHistorial",
            "choice_label" => "cadena",
            "choices" => $plazaHistoriales,
            "attr" => ["class" => "form-control form-control-sm"],
            "data" => $plazaHistorial
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Planilla',
            'anoEje' => null,
            'mesEje' => null,
            'accion' => null
        ]);
    }

}

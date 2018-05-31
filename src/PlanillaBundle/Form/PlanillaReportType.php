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
use PlanillaBundle\Entity\FuenteFinanc;

class PlanillaReportType extends AbstractType {

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
                ->add('tipoPlanilla', EntityType::class, [
                    "label" => "Tipo Planilla",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoPlanilla",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('fuente', EntityType::class, [
                    "label" => "Fuente de Financiamiento",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:FuenteFinanc",
                    "choices" => $options['fuentes'],
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('tipo', ChoiceType::class, [
                    "label" => "Tipo de Reporte",
                    "mapped" => false,
                    "required" => "required",
                    "choices" => ["MASIVO" => 1, "INDIVIDUAL" => 2],
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => 1
                ])
                ->add('planilla', ChoiceType::class, [
                    "label" => "Planilla",
                    "mapped" => false,
                    "required" => "required",
                    "choices" => ["TODOS" => 0],
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => 0
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
        $options = $form->getConfig()->getOptions();
        $mesEje = $em->getRepository('PlanillaBundle:Mes')->findOneBy(["mesEje" => $data['mesEje']]);
        $tipoPlanilla = $em->getRepository('PlanillaBundle:TipoPlanilla')->findOneBy(["id" => $data['tipoPlanilla']]);
        $fuente = $em->getRepository('PlanillaBundle:FuenteFinanc')->findOneBy(["id" => $data['fuente']]);
        if ($data['tipo'] == 2) {
            $planillas = $em->getRepository('PlanillaBundle:Planilla')->findArrayByAnoMesTipoFuente(
                    $data['anoEje'], $mesEje, $tipoPlanilla, $fuente
            );
            if (count($planillas) == 0) {
                $this->seteandoPlanilla2($form);
            } else {
                $this->seteandoPlanilla($form, $data['planilla'], $planillas);
            }
        } else {
            $this->seteandoPlanilla2($form);
        }
        $this->seteandoFuente($form, $fuente, $options);
    }

    protected function seteandoFuente(FormInterface $form, FuenteFinanc $fuente, $options) {
        $form->add('fuente', EntityType::class, [
            "label" => "Fuente de Financiamiento",
            "required" => "required",
            "class" => "PlanillaBundle:FuenteFinanc",
            "choices" => $options['fuentes'],
            "choice_label" => "nombre",
            "attr" => ["class" => "form-control form-control-sm"],
            "data" => $fuente
        ]);
    }

    protected function seteandoPlanilla(FormInterface $form, $planilla, $planillas) {
        $form->add('planilla', ChoiceType::class, [
            "label" => "Planilla",
            "mapped" => false,
            "required" => "required",
            "choices" => $planillas,
            "attr" => ["class" => "form-control form-control-sm"],
            "data" => $planilla
        ]);
    }

    protected function seteandoPlanilla2(FormInterface $form) {
        $form->add('planilla', ChoiceType::class, [
            "label" => "Planilla",
            "mapped" => false,
            "required" => "required",
            "choices" => ["TODOS" => 0],
            "attr" => ["class" => "form-control form-control-sm"],
            "data" => 0]);
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
            'fuentes' => null,
            'btnSubmit' => null
        ]);
    }

}

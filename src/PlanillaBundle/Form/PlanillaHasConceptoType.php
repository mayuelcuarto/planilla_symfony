<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use PlanillaBundle\Entity\Planilla;
use PlanillaBundle\Entity\TipoConcepto;
use PlanillaBundle\Entity\Concepto;

class PlanillaHasConceptoType extends AbstractType {

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
                ->add('tipoConcepto', EntityType::class, [
                    "label" => "Tipo de Concepto",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoConcepto",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => $options['tc_disabled']]
                ])
                ->add('concepto', EntityType::class, [
                    "label" => "Concepto",
                    "required" => "required",
                    "class" => "PlanillaBundle:Concepto",
                    "choice_label" => "concepto",
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => $options['c_disabled']]
                ])
                ->add('monto', NumberType::class, [
                    "label" => "Monto",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => 'form-submit btn btn-success form-control-sm']
                ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    function onPreSetData(FormEvent $event) {
        $form = $event->getForm();
        $options = $form->getConfig()->getOptions();
        if($options['accion'] == 1){
        $em = $this->entityManager;
        $tipoConcepto = $em->getRepository('PlanillaBundle:TipoConcepto')->find(["id" => 1]);
        $this->seteandoConceptos($form, $options['planilla'], $tipoConcepto);
        }
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $options = $form->getConfig()->getOptions();
        if($options['accion'] == 1){
        $em = $this->entityManager;
        $data = $event->getData();
        $concepto = $em->getRepository('PlanillaBundle:Concepto')->find($data['concepto']);
        $this->seteandoConcepto($form, $concepto);
        }
    }

    protected function seteandoConceptos(FormInterface $form, Planilla $planilla, TipoConcepto $tipoConcepto) {
        $em = $this->entityManager;
        $conceptos = $em->getRepository('PlanillaBundle:PlanillaHasConcepto')->findByPlanillaTipoConcepto(
                $planilla, $tipoConcepto);
        
        $form->add('concepto', EntityType::class, [
                    "label" => "Concepto",
                    "required" => "required",
                    "class" => "PlanillaBundle:Concepto",
                    "choices" => $conceptos,
                    "choice_label" => "concepto",
                    "attr" => ["class" => "form-control form-control-sm"]
                ]);
    }
    
    protected function seteandoConcepto(FormInterface $form, Concepto $concepto) {
        $form->add('concepto', EntityType::class, [
                    "label" => "Concepto",
                    "required" => "required",
                    "class" => "PlanillaBundle:Concepto",
                    "choice_label" => "concepto",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $concepto
                ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\PlanillaHasConcepto',
            'planilla' => null,
            'accion' => null,
            'tc_disabled' => false,
            'c_disabled' => false
        ]);
    }

}

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlanillaHasConceptoType extends AbstractType {

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
                    "data" => $options['tipoConcepto'],
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => true]
                ])
                ->add('concepto', EntityType::class, [
                    "label" => "Concepto",
                    "required" => "required",
                    "class" => "PlanillaBundle:Concepto",
                    "choices" => $options['conceptos'],
                    "choice_label" => "concepto",
                    "attr" => ["class" => "form-control form-control-sm"]
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
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\PlanillaHasConcepto',
            'conceptos' => null,
            'tipoConcepto' => null
            ]);
    }

}

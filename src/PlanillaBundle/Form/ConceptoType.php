<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ConceptoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tipoConcepto', EntityType::class, [
                    "label" => "Tipo de Concepto",
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoConcepto",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('concepto', TextType::class, [
                    "label" => "Nombre de Concepto",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('abreviatura', TextType::class, [
                    "label" => "Abreviatura",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('mcppConcepto', TextType::class, [
                    "label" => "Código MCPP",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 4]
                ])
                ->add('estado', CheckboxType::class, [
                    "label" => "Estado",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('esActivo', CheckboxType::class, [
                    "label" => "Activo",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('esPension', CheckboxType::class, [
                    "label" => "Pensionista",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('esPatronal', CheckboxType::class, [
                    "label" => "Patronal",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('esAsegurada', CheckboxType::class, [
                    "label" => "Asegurada",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('esAfp', CheckboxType::class, [
                    "label" => "Afp",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'PlanillaBundle\Entity\Concepto']);
    }

}

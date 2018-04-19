<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlazaEditType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tipoPlanilla', EntityType::class, [
                    "label" => "Tipo Planilla",
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoPlanilla",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => true]
                ])
                ->add('numPlaza', TextType::class, [
                    "label" => "Plaza",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 6, "disabled" => true]
                ])
                ->add('secFunc', EntityType::class, [
                    "label" => "Meta",
                    "required" => "required",
                    "class" => "PlanillaBundle:Meta",
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('especifica', EntityType::class, [
                    "label" => "Específica",
                    "required" => "required",
                    "class" => "PlanillaBundle:Especifica",
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('categoria', EntityType::class, [
                    "label" => "Categoría",
                    "required" => "required",
                    "class" => "PlanillaBundle:CategoriaOcupacional",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('estado', CheckboxType::class, [
                    "label" => "Estado",
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
        $resolver->setDefaults(['data_class' => 'PlanillaBundle\Entity\Plaza']);
    }

}

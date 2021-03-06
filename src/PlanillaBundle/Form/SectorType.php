<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SectorType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('anoEje', TextType::class, [
                    "label" => "Año",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 4]
                ])
                ->add('sector', TextType::class, [
                    "label" => "Sector",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 2]
                ])
                ->add('nombre', TextType::class, [
                    "label" => "Nombre",
                    "required" => "required",
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
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'PlanillaBundle\Entity\Sector']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planillabundle_sector';
    }

}

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AfpEditType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('regimenPensionario', EntityType::class, [
                    "label" => "Régimen Pensionario",
                    "required" => "required",
                    "class" => 'PlanillaBundle:RegimenPensionario',
                    "choice_label" => 'nombre',
                    "attr" => ["class" => 'form-control form-control-sm']
                ])
                ->add('nombre', TextType::class, [
                    "label" => "Nombre",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('snp', PercentType::class, [
                    "label" => "SNP",
                    "required" => false,
                    "scale" => 2,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('pension', PercentType::class, [
                    "label" => "Pensión",
                    "required" => false,
                    "scale" => 2,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('jubilacion', PercentType::class, [
                    "label" => "Jubilación",
                    "required" => false,
                    "scale" => 2,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('seguros', PercentType::class, [
                    "label" => "Seguros",
                    "required" => false,
                    "scale" => 2,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('ra', PercentType::class, [
                    "label" => "Comisión RA",
                    "required" => false,
                    "scale" => 2,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('raMixta', PercentType::class, [
                    "label" => "Comisión RA Mixta",
                    "required" => false,
                    "scale" => 2,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('estado', CheckboxType::class, [
                    "label" => "Estado",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => 'form-submit btn btn-success form-control-sm']
                ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'PlanillaBundle\Entity\Afp']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planillabundle_afp';
    }

}

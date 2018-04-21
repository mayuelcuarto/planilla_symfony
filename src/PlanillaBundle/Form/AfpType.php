<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AfpType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('id', TextType::class, [
                    "label" => "ID",
                    "mapped" => false,
                    "required" => "required",
                    "data" => $options['id'],
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 2]
                ])
                ->add('regimenPensionario', EntityType::class, [
                    "label" => "Régimen Pensionario",
                    "required" => "required",
                    "class" => "PlanillaBundle:RegimenPensionario",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('nombre', TextType::class, [
                    "label" => "Nombre",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('snp', NumberType::class, [
                    "label" => "SNP",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('jubilacion', NumberType::class, [
                    "label" => "Jubilación",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('seguros', NumberType::class, [
                    "label" => "Seguros",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('ra', NumberType::class, [
                    "label" => "Comisión RA",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('pension', NumberType::class, [
                    "label" => "Pensión",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('raMixta', NumberType::class, [
                    "label" => "Comisión RA Mixta",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('estado', CheckboxType::class, [
                    "label" => "Estado",
                    "required" => false,
                    "data" => $options['estado'],
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
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Afp',
            'id' => null,
            'estado' => null
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planillabundle_afp';
    }

}

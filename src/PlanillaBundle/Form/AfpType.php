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

class AfpType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id', TextType::class, array("label"=>"ID", 'mapped' => false, "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm", "maxlength" => 2
            )))
        ->add('regimenPensionario', EntityType::class, array("label"=>"Régimen Pensionario", "required"=>"required",
                "class" => 'PlanillaBundle:RegimenPensionario',
                "choice_label"  => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
        ->add('nombre', TextType::class, array("label"=>"Nombre", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('estado', CheckboxType::class, array("label"=>"Estado", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('snp', NumberType::class, array("label"=>"SNP", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('jubilacion', NumberType::class, array("label"=>"Jubilación", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('seguros', NumberType::class, array("label"=>"Seguros", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('ra', NumberType::class, array("label"=>"Comisión RA", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('pension', NumberType::class, array("label"=>"Pensión", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('raMixta', NumberType::class, array("label"=>"Comisión RA Mixta", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
        ->add('Guardar', SubmitType::class, array("attr"=>array(
                "class" => 'form-submit btn btn-success form-control-sm'
            )))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanillaBundle\Entity\Afp'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planillabundle_afp';
    }


}

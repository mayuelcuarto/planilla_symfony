<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EspecificaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anoEje', TextType::class, array("label"=>"Año", "required"=>"required","attr"=>array(
                "class" => 'form-control form-control-sm', "maxlength" => 4
            )))
            ->add('especifica', TextType::class, array("label"=>"Específica", "required"=>"required","attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('nombre', TextType::class, array("label"=>"Nombre", "required"=>"required","attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('estado', CheckboxType::class, array("label"=>"Estado", "required"=>false, "attr"=>array(
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
            'data_class' => 'PlanillaBundle\Entity\Especifica'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planillabundle_especifica';
    }


}

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EjecutoraType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pliego', EntityType::class, array("label"=>"Pliego", "required"=>"required",
                "class" => 'PlanillaBundle:Pliego',
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('secEjec', TextType::class, array("label"=>"Ejecutora", "required"=>"required", "attr"=>array(
                "class" => 'form-control form-control-sm', "maxlength" => 6
            )))
            ->add('nombre', TextType::class, array("label"=>"Nombre", "required"=>"required", "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('direccion', TextType::class, array("label"=>"Dirección", "required"=>false, "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('ruc', TextType::class, array("label"=>"R.U.C.", "required"=>false, "attr"=>array(
                "class" => 'form-control form-control-sm', "maxlength" => 11
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
            'data_class' => 'PlanillaBundle\Entity\Ejecutora'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planillabundle_ejecutora';
    }


}

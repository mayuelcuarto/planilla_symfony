<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PersonalSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('apellidoPaterno', TextType::class, array("label"=>"Apellido Paterno", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('apellidoMaterno', TextType::class, array("label"=>"Apellido Materno", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('nombre', TextType::class, array("label"=>"Nombres", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('Buscar', SubmitType::class, array("attr"=>array(
                "class" => "form-submit btn btn-success form-control-sm"
                )));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanillaBundle\Entity\Personal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planillabundle_personal';
    }


}

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CategoriaOcupacionalEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grupoOcupacional', EntityType::class, array("label"=>"Grupo Ocupacional", "required"=>"required",
                "class" => 'PlanillaBundle:GrupoOcupacional',
                "choice_label"  => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('nombre', TextType::class, array("label"=>"Nombre", "required"=>"required", "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('categoriaOcupacional', TextType::class, array("label"=>"Abreviatura", "required"=>"required", "attr"=>array(
                "class" => 'form-control form-control-sm', "maxlength" => 2
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
            'data_class' => 'PlanillaBundle\Entity\CategoriaOcupacional'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planillabundle_categoriaOcupacional';
    }


}

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ConceptoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('tipoConcepto', EntityType::class, array("label"=>"Tipo de Concepto", "required"=>"required",
                "class" => 'PlanillaBundle:TipoConcepto',
                "choice_label"  => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
                )))
            ->add('concepto', TextType::class, array("label"=>"Nombre de Concepto", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('abreviatura', TextType::class, array("label"=>"Abreviatura", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('mcppConcepto', TextType::class, array("label"=>"Código MCPP", 
                "attr"=>array(
                "maxlength" => 4,
                "class" => "form-control form-control-sm"
            )))   
            ->add('estado', CheckboxType::class, array("label"=>"Estado", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('esActivo', CheckboxType::class, array("label"=>"Activo", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('esPension', CheckboxType::class, array("label"=>"Pensionista", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('esPatronal', CheckboxType::class, array("label"=>"Patronal", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('esAsegurada', CheckboxType::class, array("label"=>"Asegurada", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
             ->add('esAfp', CheckboxType::class, array("label"=>"Afp", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('Guardar', SubmitType::class, array("attr"=>array(
                "class" => "form-submit btn btn-success form-control-sm"
            )))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanillaBundle\Entity\Concepto'
        ));
    }
}

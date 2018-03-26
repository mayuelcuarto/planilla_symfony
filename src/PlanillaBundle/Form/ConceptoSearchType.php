<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConceptoSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('tipoConcepto', ChoiceType::class, array("label"=>"Tipo", "required"=>"required", 
                'choices'  => array(
                    'INGRESO' => "1",
                    'EGRESO' => "2",
                ), 
                "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('concepto', TextType::class, array("label"=>"Nombre de Concepto", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('abreviatura', TextType::class, array("label"=>"Abreviatura", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('mcppConcepto', TextType::class, array("label"=>"Código MCPP", "required"=>false, 
                "attr"=>array(
                "maxlength" => 4,
                "class" => "form-control form-control-sm"
            )))   
            ->add('Buscar', SubmitType::class, array("attr"=>array(
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

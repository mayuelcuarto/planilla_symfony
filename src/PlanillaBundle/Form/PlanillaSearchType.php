<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlanillaSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipoPlanilla', EntityType::class, array("label"=>"Tipo Planilla", 'mapped' => false, "required"=>"required",
                "class" => 'PlanillaBundle:TipoPlanilla',
                "choice_label" => 'nombre',
                "attr" => array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('personal', TextType::class, array("label"=>"Personal", 'mapped' => false, "required"=>false,
                "attr" => array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('Buscar', SubmitType::class, array("attr"=>array(
                "class" => 'form-submit btn btn-success form-control-sm'
            )))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanillaBundle\Entity\Planilla'
        ));
    }
}

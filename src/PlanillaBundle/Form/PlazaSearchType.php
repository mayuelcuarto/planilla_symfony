<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlazaSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('tipoPlanilla', EntityType::class, array("label"=>"Tipo Planilla", "required"=>"required",
                "class" => 'PlanillaBundle:TipoPlanilla',
                "choice_label" => 'nombre',
                "attr"=>array(
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
            'data_class' => 'PlanillaBundle\Entity\Plaza'
        ));
    }
}

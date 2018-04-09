<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlanillaEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anoEje', NumberType::class, array("label"=>"Año", "required"=>"required",
                "attr" => array(
                "class" => 'form-control form-control-sm',
                "disabled" => true
            )))
            ->add('mesEje', EntityType::class, array("label"=>"Mes", "required"=>"required",
                "class" => 'PlanillaBundle:Mes',
                "choice_label" => 'nombre',
                "attr" => array(
                "class" => 'form-control form-control-sm',
                "disabled" => true
            )))
            ->add('tipoPlanilla', EntityType::class, array("label"=>"Tipo Planilla", 'mapped' => false, "required"=>"required",
                "class" => 'PlanillaBundle:TipoPlanilla',
                "choice_label" => 'nombre',
                "attr" => array(
                "class" => 'form-control form-control-sm',
                "disabled" => true
            )))
            ->add('plazaHistorial', EntityType::class, array("label"=>"Plaza", "required"=>"required",
                "class" => 'PlanillaBundle:PlazaHistorial',
                "choice_label" => 'cadena',
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
            'data_class' => 'PlanillaBundle\Entity\Planilla',
        ));
    }
}

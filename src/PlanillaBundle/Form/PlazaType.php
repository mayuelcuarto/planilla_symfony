<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlazaType extends AbstractType
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
            ->add('numPlaza', TextType::class, array("attr"=>array(
                "class" => 'form-control form-control-sm', "maxlength" => 6
            )))
            ->add('secFunc', EntityType::class, array("label"=>"Meta", "required"=>"required",
                "class" => 'PlanillaBundle:Meta',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                                  ->where('m.estado = 1');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('especifica', EntityType::class, array("label"=>"Específica", "required"=>"required",
                "class" => 'PlanillaBundle:Especifica',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                                  ->where('e.estado = 1');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('categoria', EntityType::class, array("label"=>"Categoría", "required"=>"required",
                "class" => 'PlanillaBundle:CategoriaOcupacional',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                  ->where('c.estado = 1');
                },
                "choice_label"  => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('estado', CheckboxType::class, array("label"=>"Estado", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('Guardar', SubmitType::class, array("attr"=>array(
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

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

class MetaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('programa', EntityType::class, array("label"=>"Programa", "required"=>"required",
                "class" => 'PlanillaBundle:Programa',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                  ->where('p.anoEje > 2010');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('producto', EntityType::class, array("label"=>"Producto", "required"=>"required",
                "class" => 'PlanillaBundle:Producto',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                  ->where('p.anoEje > 2010');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('actProy', EntityType::class, array("label"=>"Actividad", "required"=>"required",
                "class" => 'PlanillaBundle:ActProy',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                                  ->where('a.anoEje > 2010');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('funcion', EntityType::class, array("label"=>"Función", "required"=>"required",
                "class" => 'PlanillaBundle:Funcion',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                                  ->where('f.anoEje > 2010');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('divfunc', EntityType::class, array("label"=>"División Funcional", "required"=>"required",
                "class" => 'PlanillaBundle:Divfunc',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('d')
                                  ->where('d.anoEje > 2010');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('grpf', EntityType::class, array("label"=>"Grupo Funcional", "required"=>"required",
                "class" => 'PlanillaBundle:Grpf',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                                  ->where('g.anoEje > 2010');
                },
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('ejecutora', EntityType::class, array("label"=>"Ejecutora", "required"=>"required",
                "class" => 'PlanillaBundle:Ejecutora',
                "choice_label"  => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('meta', TextType::class, array("label"=>"Meta", "required"=>"required", "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('finalidad', TextType::class, array("label"=>"Finalidad", "required"=>"required", "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('nombre', TextType::class, array("label"=>"Nombre", "required"=>"required", "attr"=>array(
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
            'data_class' => 'PlanillaBundle\Entity\Meta'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'planillabundle_meta';
    }


}

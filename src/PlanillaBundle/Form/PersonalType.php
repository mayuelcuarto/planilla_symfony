<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PersonalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('apellidoPaterno', TextType::class, array("label"=>"Apellido Paterno", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('apellidoMaterno', TextType::class, array("label"=>"Apellido Materno", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('nombre', TextType::class, array("label"=>"Nombres", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('anexo', TextType::class, array("label"=>"Anexo", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('fechaNacimiento', BirthdayType::class, array("label"=>"Fecha de Nacimiento", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('tipoDoc', EntityType::class, array("label"=>"Tipo de Documento", "required"=>"required",
                "class" => 'PlanillaBundle:TipoDoc',
                "choice_label"  => 'nombre',
                "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                  ->where('p.estado = 1');
                },
                "attr"=>array(
                "class" => 'form-control form-control-sm'
                )))
                ->add('numeroDocumento', TextType::class, array("label"=>"Numero de Documento",  "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm", "maxlength" => 8
                )))
                ->add('sexo', EntityType::class, array("label"=>"Sexo", "required"=>"required",
                "class" => 'PlanillaBundle:Sexo',
                "choice_label"  => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
                )))
                ->add('cuspp', TextType::class, array("label"=>"CUSPP", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm", "maxlength" => 8
                )))
                ->add('numAutogenerado', TextType::class, array("label"=>"Numero Autogenerado", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm", "maxlength" => 8
                )))
                ->add('estado', CheckboxType::class, array("label"=>"Estado", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
                ->add('Guardar', SubmitType::class, array("attr"=>array(
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
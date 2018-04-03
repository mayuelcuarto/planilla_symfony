<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlazaHistorialEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codPersonal', EntityType::class, array("label"=>"Personal", "required"=>"required",
                "class" => 'PlanillaBundle:Personal',
                'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                  ->orderBy('p.apellidoPaterno, p.apellidoMaterno, p.nombre');
                },
                "choice_label" => 'cadena',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('regimenLaboral', EntityType::class, array("label"=>"Régimen Laboral", "required"=>"required",
                "class" => 'PlanillaBundle:RegimenLaboral',
                "choice_label" => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('condicionLaboral', EntityType::class, array("label"=>"Condición Laboral", "required"=>"required",
                "class" => 'PlanillaBundle:CondicionLaboral',
                "choice_label" => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('modoIngreso', EntityType::class, array("label"=>"Modo de Ingreso", "required"=>"required",
                "class" => 'PlanillaBundle:ModoIngreso',
                "choice_label" => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('resolucion', TextType::class, array("label"=>"Resolución", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
            ->add('fechaIngreso', BirthdayType::class, array("label"=>"Fecha de Ingreso", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
            ->add('unidad', EntityType::class, array("label"=>"Dirección", "required"=>"required",
                "class" => 'PlanillaBundle:Unidad',
                "choice_label" => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('cargo', TextType::class, array("label"=>"Cargo", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
            ->add('regimenPensionario', EntityType::class, array("label"=>"Régimen Pensionario", "required"=>"required",
                "class" => 'PlanillaBundle:RegimenPensionario',
                "choice_label" => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('afp', EntityType::class, array("label"=>"AFP", "required"=>"required",
                "class" => 'PlanillaBundle:Afp',
                "choice_label" => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))  
            ->add('afpMix', CheckboxType::class, array("label"=>"¿AFP Mixta?", "required"=>false, "attr"=>array(
                "class" => "form-control form-control-sm"
            )))
            ->add('fechaAfp', BirthdayType::class, array("label"=>"Fecha de Ingreso AFP", "required"=>"required", "attr"=>array(
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
            'data_class' => 'PlanillaBundle\Entity\PlazaHistorial'
        ));
    }
}

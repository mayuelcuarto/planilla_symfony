<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlazaHistorialBajaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motivoAnulacion', EntityType::class, array("label"=>"Motivo de Anulación", "required"=>"required",
                "class" => 'PlanillaBundle:MotivoAnulacion',
                "choice_label" => 'nombre',
                "attr"=>array(
                "class" => 'form-control form-control-sm'
            )))
            ->add('docAnulacion', TextType::class, array("label"=>"Documento de Anulación", "required"=>"required", "attr"=>array(
                "class" => "form-control form-control-sm"
                )))
            ->add('fechaAnulacion', BirthdayType::class, array("label"=>"Fecha de Anulación", "required"=>"required", "attr"=>array(
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

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dni', TextType::class, array("label"=>"DNI", "required"=>"required", "attr"=>array(
                "class" => "form-name form-control"
            )))                   
            ->add('nombres', TextType::class, array("label"=>"Nombre", "required"=>"required", "attr"=>array(
                "class" => "form-name form-control"
            )))
            ->add('apellidos', TextType::class, array("label"=>"Apellido", "required"=>"required", "attr"=>array(
                "class" => "form-surname form-control"
            )))
            ->add('nick', TextType::class, array("label"=>"Nick", "required"=>"required", "attr"=>array(
                "class" => "form-email form-control"
            )))
            ->add('password', PasswordType::class, array("label"=>"Contraseña", "required"=>"required", "attr"=>array(
                "class" => "form-password form-control"
            )))
            ->add('Guardar', SubmitType::class, array("attr"=>array(
                "class" => "form-submit btn btn-success"
            )))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlanillaBundle\Entity\Usuario'
        ));
    }
}

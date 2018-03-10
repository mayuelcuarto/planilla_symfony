<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                 
            ->add('nombres', TextType::class, array("label"=>"Nombres", "required"=>"required", "attr"=>array(
                "class" => "form-control"
            )))
            ->add('apellidos', TextType::class, array("label"=>"Apellidos", "required"=>"required", "attr"=>array(
                "class" => "form-control"
            )))
            ->add('dni', TextType::class, array("label"=>"DNI", "required"=>"required", "attr"=>array(
                "class" => "form-control"
            )))
            ->add('cargo', TextType::class, array("label"=>"Cargo", "required"=>"required", "attr"=>array(
                "class" => "form-control"
            )))
            ->add('nick', TextType::class, array("label"=>"Nick", "required"=>"required", "attr"=>array(
                "class" => "form-control"
            )))
            ->add('password', PasswordType::class, array("label"=>"Contraseña", "required"=>"required", "attr"=>array(
                "class" => "form-control"
            )))
            ->add('role', ChoiceType::class, array("label"=>"Rol", "required"=>"required", 
                'choices'  => array(
                    'ADMINISTRADOR' => "ROLE_ADMIN",
                    'USUARIO' => "ROLE_USER",
                ),      
                "attr"=>array(
                "class" => "form-control"
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

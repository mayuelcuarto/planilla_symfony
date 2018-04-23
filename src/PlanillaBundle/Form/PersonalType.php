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

class PersonalType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('apellidoPaterno', TextType::class, [
                    "label" => "Apellido Paterno",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('apellidoMaterno', TextType::class, [
                    "label" => "Apellido Materno",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('nombre', TextType::class, [
                    "label" => "Nombres",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('anexo', TextType::class, [
                    "label" => "Anexo",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('fechaNacimiento', BirthdayType::class, [
                    "label" => "Fecha de Nacimiento",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('tipoDoc', EntityType::class, [
                    "label" => "Tipo de Documento",
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoDoc",
                    "choice_label" => "nombre",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                ->where('p.estado = 1');
                    },
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('numeroDocumento', TextType::class, [
                    "label" => "Numero de Documento",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 8]
                ])
                ->add('sexo', EntityType::class, [
                    "label" => "Sexo",
                    "required" => "required",
                    "class" => "PlanillaBundle:Sexo",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('cuspp', TextType::class, [
                    "label" => "CUSPP",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 8]
                ])
                ->add('numAutogenerado', TextType::class, [
                    "label" => "Numero Autogenerado",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 8]
                ])
                ->add('estado', CheckboxType::class, [
                    "label" => "Estado",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['estado']
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Personal',
            'estado' => null
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planillabundle_personal';
    }

}

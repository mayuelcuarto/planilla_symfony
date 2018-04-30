<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MetaEditType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('programa', EntityType::class, [
                    "label" => "Programa",
                    "required" => "required",
                    "class" => "PlanillaBundle:Programa",
                    "choices" => $options['programa'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['programaSeleccion']
                ])
                ->add('producto', EntityType::class, [
                    "label" => "Producto",
                    "required" => "required",
                    "class" => "PlanillaBundle:Producto",
                    "choices" => $options['producto'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['productoSeleccion']
                ])
                ->add('actProy', EntityType::class, [
                    "label" => "Actividad",
                    "required" => "required",
                    "class" => "PlanillaBundle:ActProy",
                    "choices" => $options['actividad'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['actividadSeleccion']
                ])
                ->add('funcion', EntityType::class, [
                    "label" => "Función",
                    "required" => "required",
                    "class" => "PlanillaBundle:Funcion",
                    "choices" => $options['funcion'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['funcionSeleccion']
                ])
                ->add('divfunc', EntityType::class, [
                    "label" => "División Funcional",
                    "required" => "required",
                    "class" => "PlanillaBundle:Divfunc",
                    "choices" => $options['divfunc'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['divfuncSeleccion']
                ])
                ->add('grpf', EntityType::class, [
                    "label" => "Grupo Funcional",
                    "required" => "required",
                    "class" => "PlanillaBundle:Grpf",
                    "choices" => $options['grpf'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['grpfSeleccion']
                ])
                ->add('ejecutora', EntityType::class, [
                    "label" => "Ejecutora",
                    "required" => "required",
                    "class" => "PlanillaBundle:Ejecutora",
                    "choices" => $options['ejecutora'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['ejecutoraSeleccion']
                ])
                ->add('meta', TextType::class, [
                    "label" => "Meta",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('finalidad', TextType::class, [
                    "label" => "Finalidad",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('nombre', TextType::class, [
                    "label" => "Nombre",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('estado', CheckboxType::class, [
                    "label" => "Estado",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
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
            'data_class' => 'PlanillaBundle\Entity\Meta',
            'programa' => null,
            'programaSeleccion' => null,
            'producto' => null,
            'productoSeleccion' => null,
            'actividad' => null,
            'actividadSeleccion' => null,
            'funcion' => null,
            'funcionSeleccion' => null,
            'divfunc' => null,
            'divfuncSeleccion' => null,
            'grpf' => null,
            'grpfSeleccion' => null,
            'ejecutora' => null,
            'ejecutoraSeleccion' => null
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planillabundle_meta';
    }

}

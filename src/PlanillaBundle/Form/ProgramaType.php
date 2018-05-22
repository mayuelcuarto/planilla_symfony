<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProgramaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('anoEje', TextType::class, [
                    "label" => "Año",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 4],
                    "data" => $options['anoEje']
                ])
                ->add('programa', TextType::class, [
                    "label" => "Programa",
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
            'data_class' => 'PlanillaBundle\Entity\Programa',
            'estado' => null,
            'anoEje' => null
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planillabundle_programa';
    }

}

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TardanzasType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tardanzas', NumberType::class, [
                    "label" => "Minutos de tardanza",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('particulares', NumberType::class, [
                    "label" => "Minutos de permisos particulares",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('lsgh', NumberType::class, [
                    "label" => "Días de Licencia sin goce de haber",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('faltas', NumberType::class, [
                    "label" => "Días de Falta",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Planilla'
        ]);
    }

}

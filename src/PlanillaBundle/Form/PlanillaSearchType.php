<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PlanillaSearchType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('anoEje', ChoiceType::class, [
                    "label" => "Año de Origen",
                    "mapped" => false,
                    "required" => "required",
                    "choices" => $options['anoArray'],
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['anoEje']
                ])
                ->add('mesEje', EntityType::class, [
                    "label" => "Mes de Origen",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:Mes",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['mesEje']
                ])
                ->add('tipoPlanilla', EntityType::class, [
                    "label" => "Tipo Planilla",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoPlanilla",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Buscar', SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Planilla',
            'anoArray' => null,
            'anoEje' => null,
            'mesEje' => null
            ]);
    }

}

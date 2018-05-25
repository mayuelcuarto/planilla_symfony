<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlanillaFechasType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('fechaGeneracion', BirthdayType::class, [
                    "label" => "Fecha de Generación",
                    "mapped" => false,
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['fechaGeneracion']
                ])
                ->add('fechaPago', BirthdayType::class, [
                    "label" => "Fecha de Pago",
                    "mapped" => false,
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['fechaPago']
                ])
                ->add('tipoPlanilla', EntityType::class, [
                    "label" => "Tipo de Planilla",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoPlanilla",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                                ->where('t.estado = 1');
                    },
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('anoEjeActual', NumberType::class, [
                    "label" => "Año Actual",
                    "mapped" => false,
                    "required" => "required",
                    "data" => $options['anoEjeActual'],
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => true]
                ])
                ->add('mesEjeActual', EntityType::class, [
                    "label" => "Mes Actual",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:Mes",
                    "choice_label" => "nombre",
                    "data" => $options['mesEjeActual'],
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => true]
                ])
                ->add('Generar', SubmitType::class, [
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
            'anoEjeActual' => null,
            'mesEjeActual' => null,
            'fechaGeneracion' => null,
            'fechaPago' => null
        ]);
    }

}

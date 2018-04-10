<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlanillaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anoEje', NumberType::class, 
                [   "label" => "Año", 
                    "required" => "required",
                    "data" => $options['anoEje'],
                    "attr" => ["class" => 'form-control form-control-sm', "disabled" => true]
                ])
            ->add('mesEje', EntityType::class, 
                [   "label" => "Mes", 
                    "required" => "required",
                    "class" => 'PlanillaBundle:Mes',
                    "choice_label" => "nombre",
                    "data" => $options['mesEje'],
                    "attr" => ["class" => 'form-control form-control-sm', "disabled" => true]
                ])
            ->add('tipoPlanilla', EntityType::class, 
                [   "label" => "Tipo de Planilla", 
                    "mapped" => false, 
                    "required" => "required",
                    "class" => 'PlanillaBundle:TipoPlanilla',
                    "choice_label" => "nombre",
                    "data" => $options['tipoPlanilla'],
                    "attr" => ["class" => 'form-control form-control-sm', "disabled" => true]
                ])
            ->add('fuente', EntityType::class, 
                [   "label" => "Fuente de Financiamiento", 
                    "required" => "required",
                    "class" => "PlanillaBundle:FuenteFinanc",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                  ->where('p.estado = 1');
                    },
                    "choice_label" => "nombre",
                    "attr" => ["class" => 'form-control form-control-sm']
                ])
            ->add('especifica', EntityType::class, 
                [   "label" => "Específica de Gasto", 
                    "required" => "required",
                    "class" => 'PlanillaBundle:Especifica',
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                                  ->where('e.estado = 1');
                    },
                    "choice_label" => "cadena",
                    "attr" => ["class" => 'form-control form-control-sm']
                ])
            ->add('secFunc', EntityType::class, 
                [   "label" => "Meta", 
                    "required" => "required",
                    "class" => 'PlanillaBundle:Meta',
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                                  ->where('m.estado = 1');
                    },
                    "choice_label" => "cadena",
                    "attr" => ["class" => 'form-control form-control-sm']
                ])
            ->add('plazaHistorial', EntityType::class, 
                [   "label" => "Plaza de Personal", 
                    "required" => "required",
                    "class" => "PlanillaBundle:PlazaHistorial",
                    "choices" => $options['plazas'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => 'form-control form-control-sm']
                ])
            ->add('nota', TextareaType::class, 
                [   "label" => "Nota",
                    "required" => false,
                    "attr" => ["class" => 'form-control form-control-sm']
                ])
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
            'data_class' => 'PlanillaBundle\Entity\Planilla',
            'plazas' => null,
            'anoEje' => null,
            'mesEje' => null,
            'tipoPlanilla' => null
        ));
    }
}

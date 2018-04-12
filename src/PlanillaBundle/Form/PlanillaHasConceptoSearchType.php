<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PlanillaHasConceptoSearchType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tipoConcepto', EntityType::class, [
                    "label" => "Tipo de Concepto",
                    "mapped" => false,
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoConcepto",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                                ->where('t.estado = 1');
                    },
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Buscar', SubmitType::class, [
                    "attr" => ["class" => 'form-submit btn btn-success form-control-sm']
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(['data_class' => 'PlanillaBundle\Entity\PlanillaHasConcepto']);
    }

}

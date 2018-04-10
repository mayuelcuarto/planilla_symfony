<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class PliegoType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('sector', EntityType::class, [
                    "label" => "Sector",
                    "required" => "required",
                    "class" => "PlanillaBundle:Sector",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('s')
                                ->where('s.estado = 1');
                    },
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('pliego', TextType::class, [
                    "label" => "Pliego",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 3]
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
        $resolver->setDefaults(['data_class' => 'PlanillaBundle\Entity\Pliego']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planillabundle_pliego';
    }

}

<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use PlanillaBundle\Entity\CategoriaOcupacional;

class PlazaEditType extends AbstractType {

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tipoPlanilla', EntityType::class, [
                    "label" => "Tipo Planilla",
                    "required" => "required",
                    "class" => "PlanillaBundle:TipoPlanilla",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => true]
                ])
                ->add('numPlaza', TextType::class, [
                    "label" => "Plaza",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 6, "disabled" => true]
                ])
                ->add('secFunc', EntityType::class, [
                    "label" => "Meta",
                    "required" => "required",
                    "class" => "PlanillaBundle:Meta",
                    "choices" => $options['meta'],
                    "data" => $options['metaSeleccion'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('especifica', EntityType::class, [
                    "label" => "Específica",
                    "required" => "required",
                    "class" => "PlanillaBundle:Especifica",
                    "choices" => $options['especifica'],
                    "data" => $options['especificaSeleccion'],
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('grupo', EntityType::class, [
                    "label" => "Grupo Ocupacional",
                    "required" => "required",
                    "mapped" => false,
                    "class" => "PlanillaBundle:GrupoOcupacional",
                    "choices" => $options['grupoOcupacional'],
                    "data" => $options['grupoSeleccion'],
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('categoria', EntityType::class, [
                    "label" => "Categoría",
                    "required" => "required",
                    "class" => "PlanillaBundle:CategoriaOcupacional",
                    "choices" => $options['categoriaOcupacional'],
                    "data" => $options['categoriaSeleccion'],
                    "choice_label" => "nombre",
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
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    function onPreSubmit(FormEvent $event) {
        $em = $this->entityManager;
        $form = $event->getForm();
        $data = $event->getData();
        $categoria= $em->getRepository('PlanillaBundle:CategoriaOcupacional')->find($data['categoria']);
        $this->seteandoCategoria($form, $categoria);
    }    
    
    protected function seteandoCategoria(FormInterface $form, CategoriaOcupacional $categoria) {
                $em = $this->entityManager;
                $grupo = $em->getRepository('PlanillaBundle:GrupoOcupacional')->find(["grupoOcupacional" => $categoria->getGrupoOcupacional()]);
                $query = $em->createQuery("SELECT c FROM PlanillaBundle:CategoriaOcupacional c 
                                   WHERE c.grupoOcupacional = :grupo ")
                ->setParameter('grupo', $grupo);
                $categorias = $query->getResult();
                
                $form->add('categoria', EntityType::class, [
                    "label" => "Categoría Ocupacional",
                    "required" => "required",
                    "class" => "PlanillaBundle:CategoriaOcupacional",
                    "choice_label" => "nombre",
                    "choices" => $categorias,
                    "data" => $categoria,
                    "attr" => ["class" => "form-control form-control-sm"]
                ]);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Plaza',
            'grupoOcupacional' => null,
            'grupoSeleccion' => null,
            'categoriaOcupacional' => null,
            'categoriaSeleccion' => null,
            'meta' => null,
            'metaSeleccion' => null,
            'especifica' => null,
            'especificaSeleccion' => null
            ]);
    }

}

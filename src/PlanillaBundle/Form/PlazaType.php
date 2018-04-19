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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use PlanillaBundle\Entity\TipoPlanilla;
use PlanillaBundle\Entity\CategoriaOcupacional;
use PDO;

class PlazaType extends AbstractType {

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
                    "attr" => ["class" => "form-control form-control-sm", "disabled" => false],
                ])
                ->add('numPlaza', TextType::class, [
                    "label" => "Plaza",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 6]
                ])
                ->add('secFunc', EntityType::class, [
                    "label" => "Meta",
                    "required" => "required",
                    "class" => "PlanillaBundle:Meta",
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                                ->where('m.estado = 1');
                    },
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('especifica', EntityType::class, [
                    "label" => "Específica",
                    "required" => "required",
                    "class" => "PlanillaBundle:Especifica",
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('e')
                                ->where('e.estado = 1');
                    },
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('grupo', EntityType::class, [
                    "label" => "Grupo Ocupacional",
                    "required" => "required",
                    "mapped" => false,
                    "class" => "PlanillaBundle:GrupoOcupacional",
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                                ->where('g.estado = 1');
                    },
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('categoria', EntityType::class, [
                    "label" => "Categoría Ocupacional",
                    "required" => "required",
                    "class" => "PlanillaBundle:CategoriaOcupacional",
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                ->where('c.estado = 1')
                                ->andWhere('c.grupoOcupacional = :grupo')
                                ->setParameter('grupo', '01');
                    },
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('estado', CheckboxType::class, [
                    "label" => "Estado",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options["estado"]
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }
    
    function onPreSubmit(FormEvent $event) {
        $em = $this->entityManager;
        $form = $event->getForm();
        $data = $event->getData();
        $categoria= $em->getRepository('PlanillaBundle:CategoriaOcupacional')->find($data['categoria']);
        $this->seteandoCategoria($form, $categoria);
    }

    function onPreSetData(FormEvent $event) {
        $form = $event->getForm();
        $em = $this->entityManager;
        $tipoPlanilla= $em->getRepository('PlanillaBundle:TipoPlanilla')->find(["id" => 1]);
        $this->setNumPlazaInicio($form, $tipoPlanilla);
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
    
    protected function setNumPlazaInicio(FormInterface $form, TipoPlanilla $tipoPlanilla= null) {
                $em = $this->entityManager;
                $sth1 = $em->getConnection()->prepare("SELECT SugerirPlaza(:tipoPlanilla)");
                $sth1->bindValue(':tipoPlanilla', $tipoPlanilla->getId());
                $sth1->execute();
                while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {$numPlaza = $fila[0];}
                
                $form->add('numPlaza', TextType::class, [
                    "label" => "Plaza",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm", "maxlength" => 6],
                    "data" => $numPlaza
                ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\Plaza',
            'estado' => true]);
    }

}

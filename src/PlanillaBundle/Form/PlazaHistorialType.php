<?php

namespace PlanillaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use PlanillaBundle\Entity\RegimenPensionario;
use PlanillaBundle\Entity\Afp;

class PlazaHistorialType extends AbstractType {

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
                ->add('codPersonal', EntityType::class, [
                    "label" => "Personal",
                    "required" => "required",
                    "class" => "PlanillaBundle:Personal",
                    "query_builder" => function (EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                                ->where('p.estado = 1')
                                ->orderBy('p.apellidoPaterno, p.apellidoMaterno, p.nombre');
                    },
                    "choice_label" => "cadena",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('regimenLaboral', EntityType::class, [
                    "label" => "Régimen Laboral",
                    "required" => "required",
                    "class" => "PlanillaBundle:RegimenLaboral",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('condicionLaboral', EntityType::class, [
                    "label" => "Condición Laboral",
                    "required" => "required",
                    "class" => "PlanillaBundle:CondicionLaboral",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('modoIngreso', EntityType::class, [
                    "label" => "Modo de Ingreso",
                    "required" => "required",
                    "class" => "PlanillaBundle:ModoIngreso",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('resolucion', TextType::class, [
                    "label" => "Resolución",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('fechaIngreso', BirthdayType::class, [
                    "label" => "Fecha de Ingreso",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('unidad', EntityType::class, [
                    "label" => "Dirección",
                    "required" => "required",
                    "class" => "PlanillaBundle:Unidad",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('cargo', TextType::class, [
                    "label" => "Cargo",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('regimenPensionario', EntityType::class, [
                    "label" => "Régimen Pensionario",
                    "required" => "required",
                    "class" => "PlanillaBundle:RegimenPensionario",
                    "choices" => $options['regPen'],
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"],
                    "data" => $options['regPenSeleccion']
                ])
                ->add('afp', EntityType::class, [
                    "label" => "AFP",
                    "required" => "required",
                    "class" => "PlanillaBundle:Afp",
                    "choice_label" => "nombre",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('afpMix', CheckboxType::class, [
                    "label" => "¿AFP Mixta?",
                    "required" => false,
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('fechaAfp', BirthdayType::class, [
                    "label" => "Fecha de Ingreso AFP",
                    "required" => "required",
                    "attr" => ["class" => "form-control form-control-sm"]
                ])
                ->add('Guardar', SubmitType::class, [
                    "attr" => ["class" => "form-submit btn btn-success form-control-sm"]
                ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    function onPreSetData(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        $options = $form->getConfig()->getOptions();
        $em = $this->entityManager;
        if ($options['accion'] == 1) {
            $regimenPensionario = $em->getRepository('PlanillaBundle:RegimenPensionario')->findOneBy(["id" => 1]);
            $this->seteandoAfps($form, $regimenPensionario);
        } elseif ($options['accion'] == 2) {
            $regimenPensionario = $em->getRepository('PlanillaBundle:RegimenPensionario')->findOneBy(["id" => $data->getRegimenPensionario()]);
            $this->seteandoAfps($form, $regimenPensionario);
        }
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        //$options = $form->getConfig()->getOptions();
        $em = $this->entityManager;
        $afp = $em->getRepository('PlanillaBundle:Afp')->find($data['afp']);
        $this->seteandoConcepto($form, $afp);
    }

    protected function seteandoAfps(FormInterface $form, RegimenPensionario $regimenPensionario) {
        $em = $this->entityManager;
        $afps = $em->getRepository('PlanillaBundle:Afp')->findBy(["regimenPensionario" => $regimenPensionario, "estado" => 1]);

        $form->add('afp', EntityType::class, [
            "label" => "AFP",
            "required" => "required",
            "class" => "PlanillaBundle:Afp",
            "choices" => $afps,
            "choice_label" => "nombre",
            "attr" => ["class" => "form-control form-control-sm"]
        ]);
    }

    protected function seteandoAfp(FormInterface $form, Afp $afp) {
        $form->add('afp', EntityType::class, [
            "label" => "AFP",
            "required" => "required",
            "class" => "PlanillaBundle:Afp",
            "choice_label" => "nombre",
            "attr" => ["class" => "form-control form-control-sm"],
            "data" => $afp
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'PlanillaBundle\Entity\PlazaHistorial',
            'accion' => null,
            'regPen' => null,
            'regPenSeleccion' => null
        ]);
    }

}

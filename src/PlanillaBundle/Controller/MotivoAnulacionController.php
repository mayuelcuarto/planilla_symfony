<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\MotivoAnulacion;
use PlanillaBundle\Form\MotivoAnulacionType;
use PlanillaBundle\Form\MotivoAnulacionEditType;

class MotivoAnulacionController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $motivoAnulacions = $em->getRepository("PlanillaBundle:MotivoAnulacion")->findAll();
        return $this->render("@Planilla/motivoAnulacion/index.html.twig", ["motivoAnulacions" => $motivoAnulacions]);
    }

    public function addAction(Request $request) {
        $motivoAnulacion = new MotivoAnulacion();
        $em = $this->getDoctrine()->getManager();
        $id = $em->getRepository("PlanillaBundle:MotivoAnulacion")->sugerirMotivoAnulacion();
        $form = $this->createForm(MotivoAnulacionType::class, $motivoAnulacion, ["id" => $id]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $motivoAnulacion_repo = $em->getRepository("PlanillaBundle:MotivoAnulacion");
                $motivoAnulacion = $motivoAnulacion_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($motivoAnulacion != null) {
                    $status = "El motivo de anulación ya existe!!!";
                } else {
                    $motivoAnulacion = new MotivoAnulacion();
                    $motivoAnulacion->setId($form->get("id")->getData());
                    $motivoAnulacion->setNombre($form->get("nombre")->getData());
                    $motivoAnulacion->setEstado($form->get("estado")->getData());

                    $motivoAnulacion_repo->AgregarMotivoAnulacion($motivoAnulacion);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El motivo de anulación se ha creado correctamente";
                    } else {
                        $status = "Error al agregar motivo de anulación!!";
                    }
                }
            } else {
                $status = "El motivo de anulación no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("motivoAnulacion_index");
        }
        return $this->render('@Planilla/motivoAnulacion/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $motivoAnulacion_repo = $em->getRepository("PlanillaBundle:MotivoAnulacion");
        $motivoAnulacion = $motivoAnulacion_repo->find($id);

        $form = $this->createForm(MotivoAnulacionEditType::class, $motivoAnulacion);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $motivoAnulacion->setNombre($form->get("nombre")->getData());
                $motivoAnulacion->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($motivoAnulacion);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El motivo de anulación se ha editado correctamente";
                } else {
                    $status = "Error al editar motivo de anulación!!";
                }
            } else {
                $status = "El motivo de anulación no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("motivoAnulacion_index");
        }
        return $this->render('@Planilla/motivoAnulacion/edit.html.twig', ["form" => $form->createView()]);
    }

}

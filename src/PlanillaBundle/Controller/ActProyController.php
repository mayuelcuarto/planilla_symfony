<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\ActProy;
use PlanillaBundle\Form\ActProyType;
use PlanillaBundle\Form\ActProyEditType;

class ActProyController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $actividades = $em->getRepository("PlanillaBundle:ActProy")->findByMajorToAnoEje(2010);
        return $this->render("@Planilla/actividad/index.html.twig", ["actividades" => $actividades]);
    }

    public function addAction(Request $request) {
        $anoEje = \date("Y");
        $actividad = new ActProy();
        $form = $this->createForm(ActProyType::class, $actividad, ["estado" => true, "anoEje" => $anoEje]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $actividad_repo = $em->getRepository("PlanillaBundle:ActProy");
                $actividad = $actividad_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "actProy" => $form->get("actProy")->getData()
                ]);
                if ($actividad != null) {
                    $status = "El actividad ya existe!!!";
                } else {
                    $actividad = new ActProy();
                    $actividad->setAnoEje($form->get("anoEje")->getData());
                    $actividad->setActProy($form->get("actProy")->getData());
                    $actividad->setNombre($form->get("nombre")->getData());
                    $actividad->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($actividad);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La actividad se ha creado correctamente";
                    } else {
                        $status = "Error al agregar actividad!!";
                    }
                }
            } else {
                $status = "La actividad no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("actividad_index");
        }
        return $this->render('@Planilla/actividad/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $actividad_repo = $em->getRepository("PlanillaBundle:ActProy");
        $actividad = $actividad_repo->find($id);
        $actividad_aux = $actividad;
        $form = $this->createForm(ActProyEditType::class, $actividad);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $actividad2 = $actividad_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "actProy" => $form->get("actProy")->getData()
                ]);
                if ($actividad2 != null and $actividad2 != $actividad_aux) {
                    $status = "La actividad ya existe!!!";
                } else {
                    $actividad->setAnoEje($form->get("anoEje")->getData());
                    $actividad->setActProy($form->get("actProy")->getData());
                    $actividad->setNombre($form->get("nombre")->getData());
                    $actividad->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($actividad);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La actividad se ha editado correctamente";
                    } else {
                        $status = "Error al editar actividad!!";
                    }
                }
            } else {
                $status = "La actividad no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("actividad_index");
        }
        return $this->render('@Planilla/actividad/edit.html.twig', ["form" => $form->createView()]);
    }

}

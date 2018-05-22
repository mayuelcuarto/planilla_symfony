<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Funcion;
use PlanillaBundle\Form\FuncionType;
use PlanillaBundle\Form\FuncionEditType;

class FuncionController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $funcions = $em->getRepository("PlanillaBundle:Funcion")->findAll();
        return $this->render("@Planilla/funcion/index.html.twig", ["funcions" => $funcions]);
    }

    public function addAction(Request $request) {
        $anoEje = \date("Y");
        $funcion = new Funcion();
        $form = $this->createForm(FuncionType::class, $funcion, ["estado" => true, "anoEje" => $anoEje]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $funcion_repo = $em->getRepository("PlanillaBundle:Funcion");
                $funcion = $funcion_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "funcion" => $form->get("funcion")->getData()
                ]);
                if ($funcion != null) {
                    $status = "La función ya existe!!!";
                } else {
                    $funcion = new Funcion();
                    $funcion->setAnoEje($form->get("anoEje")->getData());
                    $funcion->setFuncion($form->get("funcion")->getData());
                    $funcion->setNombre($form->get("nombre")->getData());
                    $funcion->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($funcion);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La función se ha creado correctamente";
                    } else {
                        $status = "Error al agregar función!!";
                    }
                }
            } else {
                $status = "La función no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("funcion_index");
        }
        return $this->render('@Planilla/funcion/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $funcion_repo = $em->getRepository("PlanillaBundle:Funcion");
        $funcion = $funcion_repo->find($id);
        $funcion_aux = $funcion;
        $form = $this->createForm(FuncionEditType::class, $funcion);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $funcion2 = $funcion_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "funcion" => $form->get("funcion")->getData()
                ]);
                if ($funcion2 != null and $funcion2 != $funcion_aux) {
                    $status = "La función ya existe!!!";
                } else {
                    $funcion->setAnoEje($form->get("anoEje")->getData());
                    $funcion->setFuncion($form->get("funcion")->getData());
                    $funcion->setNombre($form->get("nombre")->getData());
                    $funcion->setEstado($form->get("estado")->getData());
                    $em->persist($funcion);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La función se ha editado correctamente";
                    } else {
                        $status = "Error al editar función!!";
                    }
                }
            } else {
                $status = "La función no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("funcion_index");
        }
        return $this->render('@Planilla/funcion/edit.html.twig', ["form" => $form->createView()]);
    }

}

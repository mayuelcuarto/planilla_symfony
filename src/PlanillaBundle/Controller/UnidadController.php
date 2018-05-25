<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Unidad;
use PlanillaBundle\Form\UnidadType;

class UnidadController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $unidad_repo = $em->getRepository("PlanillaBundle:Unidad");
        $unidades = $unidad_repo->findAll();

        return $this->render("@Planilla/unidad/index.html.twig", ["unidades" => $unidades]);
    }

    public function addAction(Request $request) {
        $unidad = new Unidad();
        $form = $this->createForm(UnidadType::class, $unidad, ["estado" => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $unidad_repo = $em->getRepository("PlanillaBundle:Unidad");
                $unidad = $unidad_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($unidad != null) {
                    $status = "La unidad ya existe!!!";
                } else {
                    $unidad = new Unidad();
                    $unidad->setNombre($form->get("nombre")->getData());
                    $unidad->setAbrev($form->get("abrev")->getData());
                    $unidad->setEstado($form->get("estado")->getData());

                    $em->persist($unidad);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La unidad se ha creado correctamente";
                    } else {
                        $status = "Error al crear unidad!!";
                    }
                }
            } else {
                $status = "La unidad no se ha creado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("unidad_index");
        }
        return $this->render('@Planilla/unidad/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $unidad_repo = $em->getRepository("PlanillaBundle:Unidad");
        $unidad = $unidad_repo->find($id);
        $form = $this->createForm(UnidadType::class, $unidad, ["estado" => $unidad->getEstado()]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $unidad->setNombre($form->get("nombre")->getData());
                $unidad->setAbrev($form->get("abrev")->getData());
                $unidad->setEstado($form->get("estado")->getData());

                $em->persist($unidad);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El unidad se ha editado correctamente";
                } else {
                    $status = "Error al editar unidad!!";
                }
            } else {
                $status = "El unidad no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("unidad_index");
        }
        return $this->render('@Planilla/unidad/edit.html.twig', ["form" => $form->createView()]);
    }

}

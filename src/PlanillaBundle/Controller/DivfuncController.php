<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Divfunc;
use PlanillaBundle\Form\DivfuncType;

class DivfuncController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $divfuncs = $em->getRepository("PlanillaBundle:Divfunc")->findAll();
        return $this->render("@Planilla/divfunc/index.html.twig", ["divfuncs" => $divfuncs]);
    }

    public function addAction(Request $request) {
        $divfunc = new Divfunc();
        $form = $this->createForm(DivfuncType::class, $divfunc, ["estado" => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $divfunc_repo = $em->getRepository("PlanillaBundle:Divfunc");
                $divfunc = $divfunc_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "divfunc" => $form->get("divfunc")->getData()
                ]);
                if ($divfunc != null) {
                    $status = "El divfunc ya existe!!!";
                } else {
                    $divfunc = new Divfunc();
                    $divfunc->setAnoEje($form->get("anoEje")->getData());
                    $divfunc->setDivfunc($form->get("divfunc")->getData());
                    $divfunc->setNombre($form->get("nombre")->getData());
                    $divfunc->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($divfunc);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La división funcional se ha creado correctamente";
                    } else {
                        $status = "Error al agregar división funcional!!";
                    }
                }
            } else {
                $status = "La división funcional no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("divfunc_index");
        }
        return $this->render('@Planilla/divfunc/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $divfunc_repo = $em->getRepository("PlanillaBundle:Divfunc");
        $divfunc = $divfunc_repo->find($id);
        $form = $this->createForm(DivfuncType::class, $divfunc, ["estado" => $divfunc->getEstado()]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $divfunc->setAnoEje($form->get("anoEje")->getData());
                $divfunc->setDivfunc($form->get("divfunc")->getData());
                $divfunc->setNombre($form->get("nombre")->getData());
                $divfunc->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($divfunc);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La división funcional se ha editado correctamente";
                } else {
                    $status = "Error al editar división funcional!!";
                }
            } else {
                $status = "La división funcional no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("divfunc_index");
        }
        return $this->render('@Planilla/divfunc/edit.html.twig', ["form" => $form->createView()]);
    }

}

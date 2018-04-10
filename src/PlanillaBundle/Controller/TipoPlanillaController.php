<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\TipoPlanilla;
use PlanillaBundle\Form\TipoPlanillaType;

class TipoPlanillaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $tipoPlanilla_repo = $em->getRepository("PlanillaBundle:TipoPlanilla");
        $tipoPlanillas = $tipoPlanilla_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/tipoPlanilla/index.html.twig", ["tipoPlanillas" => $tipoPlanillas]);
    }

    public function addAction(Request $request) {
        $tipoPlanilla = new TipoPlanilla();
        $form = $this->createForm(TipoPlanillaType::class, $tipoPlanilla);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $tipoPlanilla_repo = $em->getRepository("PlanillaBundle:TipoPlanilla");
                $tipoPlanilla = $tipoPlanilla_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($tipoPlanilla != null) {
                    $status = "El tipo de planilla ya existe!!!";
                } else {
                    $tipoPlanilla = new TipoPlanilla();
                    $tipoPlanilla->setNombre($form->get("nombre")->getData());
                    $tipoPlanilla->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tipoPlanilla);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El tipo de planilla se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("tipoPlanilla_index");
        }
        return $this->render('@Planilla/tipoPlanilla/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $tipoPlanilla_repo = $em->getRepository("PlanillaBundle:TipoPlanilla");
        $tipoPlanilla = $tipoPlanilla_repo->find($id);

        $form = $this->createForm(TipoPlanillaType::class, $tipoPlanilla);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla->setNombre($form->get("nombre")->getData());
                $tipoPlanilla->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($tipoPlanilla);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El tipo de planilla se ha editado correctamente";
                } else {
                    $status = "Error al editar tipo de planilla!!";
                }
            } else {
                $status = "El tipo de planilla no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("tipoPlanilla_index");
        }
        return $this->render('@Planilla/tipoPlanilla/edit.html.twig', ["form" => $form->createView()]);
    }

}

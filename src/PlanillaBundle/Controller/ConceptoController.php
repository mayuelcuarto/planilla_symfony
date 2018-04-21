<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Concepto;
use PlanillaBundle\Form\ConceptoType;

class ConceptoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $conceptos = $em->getRepository("PlanillaBundle:Concepto")->findAll();
        return $this->render("@Planilla/concepto/index.html.twig", ["conceptos" => $conceptos]);
    }

    public function addAction(Request $request) {
        $concepto = new Concepto();
        $form = $this->createForm(ConceptoType::class, $concepto, ["estado" => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $concepto_repo = $em->getRepository("PlanillaBundle:Concepto");
                $concepto = $concepto_repo->findOneBy(["concepto" => $form->get("concepto")->getData()]);
                if ($concepto != null) {
                    $status = "El concepto ya existe!!!";
                } else {
                    $concepto = new Concepto();
                    $concepto->setTipoConcepto($form->get("tipoConcepto")->getData());
                    $concepto->setConcepto($form->get("concepto")->getData());
                    $concepto->setMcppConcepto($form->get("mcppConcepto")->getData());
                    $concepto->setAbreviatura($form->get("abreviatura")->getData());
                    $concepto->setEstado($form->get("estado")->getData());
                    $concepto->setEsActivo($form->get("esActivo")->getData());
                    $concepto->setEsPension($form->get("esPension")->getData());
                    $concepto->setEsPatronal($form->get("esPatronal")->getData());
                    $concepto->setEsAsegurada($form->get("esAsegurada")->getData());
                    $concepto->setEsAfp($form->get("esAfp")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($concepto);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El concepto se ha creado correctamente";
                    } else {
                        $status = "Error al agregar concepto!!";
                    }
                }
            } else {
                $status = "El concepto no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("concepto_index");
        }
        return $this->render('@Planilla/concepto/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $concepto_repo = $em->getRepository("PlanillaBundle:Concepto");
        $concepto = $concepto_repo->find($id);
        $form = $this->createForm(ConceptoType::class, $concepto, ["estado" => $concepto->getEstado()]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $concepto->setTipoConcepto($form->get("tipoConcepto")->getData());
                $concepto->setConcepto($form->get("concepto")->getData());
                $concepto->setMcppConcepto($form->get("mcppConcepto")->getData());
                $concepto->setAbreviatura($form->get("abreviatura")->getData());
                $concepto->setEstado($form->get("estado")->getData());
                $concepto->setEsActivo($form->get("esActivo")->getData());
                $concepto->setEsPension($form->get("esPension")->getData());
                $concepto->setEsPatronal($form->get("esPatronal")->getData());
                $concepto->setEsAsegurada($form->get("esAsegurada")->getData());
                $concepto->setEsAfp($form->get("esAfp")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($concepto);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El concepto se ha editado correctamente";
                } else {
                    $status = "Error al editar concepto!!";
                }
            } else {
                $status = "El concepto no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("concepto_index");
        }
        return $this->render('@Planilla/concepto/edit.html.twig', ["form" => $form->createView()]);
    }

}

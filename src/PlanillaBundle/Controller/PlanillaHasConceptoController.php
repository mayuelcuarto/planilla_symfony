<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\PlanillaHasConcepto;
use PlanillaBundle\Form\PlanillaHasConceptoType;
use PlanillaBundle\Form\TardanzasType;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlanillaHasConceptoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction($planillaId) {
        $em = $this->getDoctrine()->getManager();
        $planillaHasConceptos = $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->findBy(["planilla" => $planillaId]);
        $planilla = $em->getRepository("PlanillaBundle:Planilla")->find($planillaId);

        return $this->render("@Planilla/planillaHasConcepto/index.html.twig", [
                    "planillaHasConceptos" => $planillaHasConceptos,
                    "planillaId" => $planillaId,
                    "planilla" => $planilla
        ]);
    }

    public function addAction(Request $request, $planillaId) {
        $em = $this->getDoctrine()->getManager();
        $planillaHasConcepto = new PlanillaHasConcepto();
        $planilla = $em->getRepository("PlanillaBundle:Planilla")->findOneBy(["id" => $planillaId]);
        $form = $this->createForm(PlanillaHasConceptoType::class, $planillaHasConcepto, [
            "planilla" => $planilla,
            "accion" => 1]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planillaHasConcepto = new PlanillaHasConcepto();
                $planillaHasConcepto->setPlanilla($planilla);
                $planillaHasConcepto->setConcepto($form->get("concepto")->getData());
                $planillaHasConcepto->setMonto($form->get("monto")->getData());
                $planillaHasConcepto->setFechaIng(new \DateTime('now'));
                $planillaHasConcepto->setUsuario($this->getUser());

                $em->persist($planillaHasConcepto);
                $flush = $em->flush();
                $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->ActualizarPlanillaAfp($planilla);
                $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->ActualizarEsSalud($planilla);
                if ($flush == null) {
                    $status = "El concepto de planilla se agregó correctamente";
                } else {
                    $status = "Error al agregar concepto de planilla!!";
                }
            } else {
                $status = "El concepto de planilla no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planillaHasConcepto_index", ["planillaId" => $planillaId]);
        }
        return $this->render('@Planilla/planillaHasConcepto/add.html.twig', [
                    "form" => $form->createView(),
                    "planillaId" => $planillaId
        ]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        //$planillaHasConcepto = new PlanillaHasConcepto();
        $planillaHasConcepto_repo = $em->getRepository("PlanillaBundle:PlanillaHasConcepto");
        $planillaHasConcepto = $planillaHasConcepto_repo->find($id);
        $planilla = $planillaHasConcepto->getPlanilla();
        $concepto = $planillaHasConcepto->getConcepto();
        $form = $this->createForm(PlanillaHasConceptoType::class, $planillaHasConcepto, [
            "accion" => 2,
            "tc_disabled" => true,
            "c_disabled" => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planillaHasConcepto->setConcepto($concepto);
                $planillaHasConcepto->setMonto($form->get("monto")->getData());
                $planillaHasConcepto->setUsuario($this->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($planillaHasConcepto);
                $flush = $em->flush();
                $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->ActualizarPlanillaAfp($planilla);
                $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->ActualizarEsSalud($planilla);
                if ($flush == null) {
                    $status = "El concepto de planilla se ha editado correctamente";
                } else {
                    $status = "Error al editar concepto de planilla!!";
                }
            } else {
                $status = "El concepto de planilla no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planillaHasConcepto_index", ["planillaId" => $planillaHasConcepto->getPlanilla()->getId()]);
        }
        return $this->render('@Planilla/planillaHasConcepto/edit.html.twig', [
                    "form" => $form->createView(),
                    "planillaId" => $planillaHasConcepto->getPlanilla()->getId()
        ]);
    }
    
    
    public function tardanzasAction(Request $request, $planillaId){
        $em = $this->getDoctrine()->getManager();
        //$planillaHasConcepto = new PlanillaHasConcepto();
        $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
        $planilla = $planilla_repo->find($planillaId);
        
        $form = $this->createForm(TardanzasType::class, $planilla);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planilla->setTardanzas($form->get("tardanzas")->getData());
                $planilla->setParticulares($form->get("particulares")->getData());
                $planilla->setLsgh($form->get("lsgh")->getData());
                $planilla->setFaltas($form->get("faltas")->getData());

                $em->persist($planilla);
                $flush = $em->flush();
                $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->ActualizarInasistencias($planilla);
                $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->ActualizarEsSalud($planilla);
                if ($flush == null) {
                    $status = "Tardanzas descargadas correctamente";
                } else {
                    $status = "Error al descargar tardanzas!!";
                }
            } else {
                $status = "Las tardanzas no se han descargado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planillaHasConcepto_index", ["planillaId" => $planillaId]);
        }
        return $this->render('@Planilla/planillaHasConcepto/tardanzas.html.twig', [
                    "form" => $form->createView()
        ]);
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $planillaHasConcepto_repo = $em->getRepository("PlanillaBundle:PlanillaHasConcepto");
        $planillaHasConcepto = $planillaHasConcepto_repo->find($id);
        $planilla = $planillaHasConcepto->getPlanilla();

        $em->remove($planillaHasConcepto);
        $flush = $em->flush();
        $em->getRepository("PlanillaBundle:PlanillaHasConcepto")->ActualizarPlanillaAfp($planilla);
        if ($flush == null) {
            $status = "El concepto de planilla se ha eliminado correctamente";
        } else {
            $status = "Error al eliminar concepto de planilla!!";
        }

        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute("planillaHasConcepto_index", [
            "planillaId" => $planillaHasConcepto->getPlanilla()->getId()]);
    }

    public function modifyConceptoAction(Request $request) {
        $tipoConcepto_id = $request->query->get("tipoConcepto");
        $planilla_id = $request->query->get("planilla");
        $em = $this->getDoctrine()->getManager();
        $tipoConcepto = $em->getRepository('PlanillaBundle:TipoConcepto')->findOneBy(['id' => $tipoConcepto_id]);
        $planilla = $em->getRepository('PlanillaBundle:Planilla')->findOneBy(['id' => $planilla_id]);
        $conceptos = $em->getRepository('PlanillaBundle:PlanillaHasConcepto')->findArrayByPlanillaTipoConcepto($planilla, $tipoConcepto);
        return new JsonResponse($conceptos);
    }

}

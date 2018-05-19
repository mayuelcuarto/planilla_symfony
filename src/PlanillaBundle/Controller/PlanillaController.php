<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Planilla;
use PlanillaBundle\Form\PlanillaType;
use PlanillaBundle\Form\PlanillaGeneracionType;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlanillaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        //$anoEje = 2017;
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        //$mesEje = $mes_repo->findOneBy(["mesEje" => 10]);
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);
        $planillas = $em->getRepository("PlanillaBundle:Planilla")->findBy(["anoEje" => $anoEje, "mesEje" => $mesEje]);
        return $this->render("@Planilla/planilla/index.html.twig", ["planillas" => $planillas]);
    }

    public function addAction(Request $request) {
        $planilla = new Planilla();
        $em = $this->getDoctrine()->getManager();
        //$anoEje = 2017;
        $anoEje = \date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        //$mesEje = $mes_repo->findOneBy(array("mesEje" => 10));
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);

        $form = $this->createForm(PlanillaType::class, $planilla, [
            'anoEje' => $anoEje,
            'mesEje' => $mesEje,
            'accion' => 1
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
                $planilla = $planilla_repo->findOneBy([
                    "plazaHistorial" => $form->get("plazaHistorial")->getData(),
                    "anoEje" => $anoEje,
                    "mesEje" => $mesEje,
                ]);
                if ($planilla != null) {
                    $status = "La planilla ya existe!!!";
                } else {
                    $planilla = new Planilla();
                    $planilla->setAnoEje($anoEje);
                    $planilla->setMesEje($mesEje);
                    $planilla->setFuente($form->get("fuente")->getData());
                    $planilla->setEspecifica($form->get("plazaHistorial")->getData()->getPlaza()->getEspecifica());
                    $planilla->setSecFunc($form->get("plazaHistorial")->getData()->getPlaza()->getSecFunc());
                    $planilla->setPlazaHistorial($form->get("plazaHistorial")->getData());
                    $planilla->setNota($form->get("nota")->getData());
                    $planilla->setUsuario($this->getUser());
                    $planilla->setFechaGeneracion(new \DateTime('now'));
                    $planilla->setFechaPago(new \DateTime('now'));
                    $planilla->setFechaIng(new \DateTime('now'));
                    $planilla->setRemAseg(0.00);
                    $planilla->setRemNoaseg(0.00);
                    $planilla->setTotalEgreso(0.00);
                    $planilla->setPatronal(0.00);
                    $planilla->setTardanzas(0);
                    $planilla->setParticulares(0);
                    $planilla->setLsgh(0);
                    $planilla->setFaltas(0);
                    $em->persist($planilla);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La planilla se ha creado correctamente";
                    } else {
                        $status = "Error al agregar planilla!!";
                    }
                }
            } else {
                $status = "La planilla no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planilla_index");
        }
        return $this->render('@Planilla/planilla/add.html.twig', [
                    "form" => $form->createView()
        ]);
    }

    public function editAction(Request $request, $id) {
        //$planilla = new Planilla();
        $em = $this->getDoctrine()->getManager();
        //$anoEje = 2017;
        $anoEje = \date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        //$mesEje = $mes_repo->findOneBy(array("mesEje" => 10));
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);
        $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
        $planilla = $planilla_repo->find($id);
        $plazaHistorial = $planilla->getPlazaHistorial();
        $form = $this->createForm(PlanillaType::class, $planilla, [
            'anoEje' => $anoEje,
            'mesEje' => $mesEje,
            'accion' => 2
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planilla->setAnoEje($anoEje);
                $planilla->setMesEje($mesEje);
                $planilla->setFuente($form->get("fuente")->getData());
                $planilla->setEspecifica($plazaHistorial->getPlaza()->getEspecifica());
                $planilla->setSecFunc($plazaHistorial->getPlaza()->getSecFunc());
                $planilla->setPlazaHistorial($plazaHistorial);
                $planilla->setNota($form->get("nota")->getData());
                $planilla->setUsuario($this->getUser());

                $em->persist($planilla);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La planilla se ha editado correctamente";
                } else {
                    $status = "Error al editar planilla!!";
                }
            } else {
                $status = "La planilla no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planilla_index");
        }
        return $this->render('@Planilla/planilla/edit.html.twig', [
                    "form" => $form->createView()
        ]);
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
        $planilla = $planilla_repo->find($id);

        $em->remove($planilla);
        $flush = $em->flush();
        if ($flush == null) {
            $status = "La planilla se ha eliminado correctamente";
        } else {
            $status = "Error al eliminar planilla!!";
        }

        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute("planilla_index");
    }

    public function generacionAction(Request $request) {
        $planilla = new Planilla();
        $em = $this->getDoctrine()->getManager();
        $anoEje = \date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);

        for ($i = 2016; $i <= $anoEje; $i++) {
            $anoArray[$i] = $i;
        }

        $form = $this->createForm(PlanillaGeneracionType::class, $planilla, [
            'anoEjeActual' => $anoEje,
            'mesEjeActual' => $mesEje,
            'anoArray' => $anoArray
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $anoEjeOrigen = $form->get("anoEjeOrigen")->getData();
                $mesEjeOrigen = $form->get("mesEjeOrigen")->getData();
                $usuario = $this->getUser();
                $em->getRepository("PlanillaBundle:Planilla")->GeneracionPlanilla($anoEjeOrigen, $mesEjeOrigen, $usuario);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La planilla se ha generado correctamente para el presente periodo";
                } else {
                    $status = "Error al generar planilla!!";
                }
            } else {
                $status = "La planilla no se generó, porque los parámetros no son válidos!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planilla_generacion");
        }
        return $this->render('@Planilla/planilla/generacion.html.twig', [
                    "form" => $form->createView()
        ]);
    }

    public function modifyPlazaHistorialAction(Request $request) {
        $tipoPlanilla_id = $request->query->get("tipoPlanilla");
        $em = $this->getDoctrine()->getManager();
        //$anoEje = 2017;
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        //$mesEje = $mes_repo->findOneBy(["mesEje" => 10]);
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);

        $tipoPlanilla = $em->getRepository('PlanillaBundle:TipoPlanilla')->find(['id' => $tipoPlanilla_id]);
        $plazaHistoriales = $em->getRepository('PlanillaBundle:PlazaHistorial')->findArrayByTipoPlanillaAnoEjeMesEje($tipoPlanilla, $anoEje, $mesEje);
        return new JsonResponse($plazaHistoriales);
    }

}

<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Planilla;
use PlanillaBundle\Form\PlanillaType;
use PlanillaBundle\Form\PlanillaSearchType;
use PlanillaBundle\Form\PlanillaGeneracionType;
use PlanillaBundle\Form\PlanillaFechasType;
use PlanillaBundle\Form\PlanillaReportType;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlanillaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);
        $planillas = $em->getRepository("PlanillaBundle:Planilla")->findBy(["anoEje" => $anoEje, "mesEje" => $mesEje]);
        return $this->render("@Planilla/planilla/index.html.twig", [
                    "planillas" => $planillas,
                    "anoEje" => $anoEje,
                    "mesEje" => $mesEje->getNombre()
        ]);
    }

    public function consultaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);
        $fuente_repo = $em->getRepository("PlanillaBundle:FuenteFinanc");
        $fuentes = $fuente_repo->findBy(["anoEje" => $anoEje]);

        $planilla = new Planilla();
        for ($i = 2008; $i <= $anoEje; $i++) {
            $anoArray[$i] = $i;
        }
        $form = $this->createForm(PlanillaSearchType::class, $planilla, [
            'anoArray' => $anoArray,
            'anoEje' => $anoEje,
            'mesEje' => $mesEje,
            'fuentes' => $fuentes
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $anoEjeForm = $form->get("anoEje")->getData();
                $mesEjeForm = $form->get("mesEje")->getData();
                $fuenteFinanc = $form->get("fuente")->getData();

                $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
                $planillas = $planilla_repo->findByAnoMesTipoFuente($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);

                $sumaRemAseg = $planilla_repo->SumaRemAseg($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaRemNoAseg = $planilla_repo->SumaRemNoAseg($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaTotalEgreso = $planilla_repo->SumaTotalEgreso($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                if (count($planillas) != 0) {
                    $status = "Listando " . count($planillas) . " registros";
                } else {
                    $status = "No se encontraron registros de coincidencia";
                }
            } else {
                $status = "La consulta no pudo procesarse, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->render("@Planilla/planilla/consulta.html.twig", [
                        "form" => $form->createView(),
                        "planillas" => $planillas,
                        "sumaRemAseg" => $sumaRemAseg,
                        "sumaRemNoAseg" => $sumaRemNoAseg,
                        "sumaTotalEgreso" => $sumaTotalEgreso
            ]);
        }
        return $this->render("@Planilla/planilla/consulta.html.twig", [
                    "form" => $form->createView(),
                    "planillas" => null,
                    "sumaRemAseg" => null,
                    "sumaRemNoAseg" => null,
                    "sumaTotalEgreso" => null
        ]);
    }

    public function addAction(Request $request) {
        $planilla = new Planilla();
        $em = $this->getDoctrine()->getManager();
        $anoEje = \date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
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
        $em = $this->getDoctrine()->getManager();
        $anoEje = \date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
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
        
        if($mesEje->getMesEje() == 1){
            $anoEjeOrigen = $anoEje - 1;
            $mesEjeOrigen = $mes_repo->findOneBy(["mesEje" => 12]);
        }else{
            $anoEjeOrigen = $anoEje;
            $mesEjeOrigen = $mes_repo->findOneBy(["mesEje" => (\date("m") - 1)]);
        }

        $form = $this->createForm(PlanillaGeneracionType::class, $planilla, [
            'anoEjeActual' => $anoEje,
            'mesEjeActual' => $mesEje,
            'anoArray' => $anoArray,
            'anoEjeOrigen' => $anoEjeOrigen,
            'mesEjeOrigen' => $mesEjeOrigen
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

    public function fechasAction(Request $request) {
        $planilla = new Planilla();
        $em = $this->getDoctrine()->getManager();
        $anoEje = \date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);

        $form = $this->createForm(PlanillaFechasType::class, $planilla, [
            'anoEjeActual' => $anoEje,
            'mesEjeActual' => $mesEje,
            'fechaGeneracion' => new \DateTime('now'),
            'fechaPago' => new \DateTime('now')
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $fechaGeneracion = $form->get("fechaGeneracion")->getData();
                $fechaPago = $form->get("fechaPago")->getData();
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $em->getRepository("PlanillaBundle:Planilla")->PlanillaFechas($tipoPlanilla->getId(), $fechaGeneracion, $fechaPago);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "Las fechas de generación y pago se han generado correctamente para el periodo actual";
                } else {
                    $status = "Error al generar fecha de planilla!!";
                }
            } else {
                $status = "Las fechas de planilla no se generaron, porque los parámetros no son válidos!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planilla_fechas");
        }
        return $this->render('@Planilla/planilla/fechas.html.twig', [
                    "form" => $form->createView()
        ]);
    }

    public function totalesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);
        $fuente_repo = $em->getRepository("PlanillaBundle:FuenteFinanc");
        $fuentes = $fuente_repo->findBy(["anoEje" => $anoEje]);

        $planilla = new Planilla();
        for ($i = 2008; $i <= $anoEje; $i++) {
            $anoArray[$i] = $i;
        }

        $form = $this->createForm(PlanillaSearchType::class, $planilla, [
            'anoEje' => $anoEje,
            'mesEje' => $mesEje,
            'anoArray' => $anoArray,
            'fuentes' => $fuentes
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $anoEjeForm = $form->get("anoEje")->getData();
                $mesEjeForm = $form->get("mesEje")->getData();
                $fuenteFinanc = $form->get("fuente")->getData();

                $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
                $planillas = $planilla_repo->findByAnoMesTipoFuente($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaRemAseg = $planilla_repo->SumaRemAseg($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaRemNoAseg = $planilla_repo->SumaRemNoAseg($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaTotalEgreso = $planilla_repo->SumaTotalEgreso($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
            } else {
                $status = "La consulta no pudo procesarse, porque el formulario no es válido!!";
            }
            if (isset($status)) {
                $this->session->getFlashBag()->add("status", $status);
            }
            return $this->render("PlanillaBundle:planilla:reporteTotales.html.php", [
                        "planillas" => $planillas,
                        "sumaRemAseg" => $sumaRemAseg,
                        "sumaRemNoAseg" => $sumaRemNoAseg,
                        "sumaTotalEgreso" => $sumaTotalEgreso,
                        "tipoPlanilla" => $tipoPlanilla,
                        "anoEje" => $anoEjeForm,
                        "mesEje" => $mesEjeForm,
                        "fuente" => $fuenteFinanc
            ]);
        }

        return $this->render("@Planilla/planilla/totales.html.twig", [
                    "form" => $form->createView()
        ]);
    }

    public function reporteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);
        $fuente_repo = $em->getRepository("PlanillaBundle:FuenteFinanc");
        $fuentes = $fuente_repo->findBy(["anoEje" => $anoEje]);

        $planilla = new Planilla();
        for ($i = 2008; $i <= $anoEje; $i++) {
            $anoArray[$i] = $i;
        }

        $form = $this->createForm(PlanillaReportType::class, $planilla, [
            'anoEje' => $anoEje,
            'mesEje' => $mesEje,
            'anoArray' => $anoArray,
            'fuentes' => $fuentes
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $anoEjeForm = $form->get("anoEje")->getData();
                $mesEjeForm = $form->get("mesEje")->getData();
                $fuenteFinanc = $form->get("fuente")->getData();
                $tipoForm = $form->get("tipo")->getData();
                $planillaForm = $form->get("planilla")->getData();

                $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
                if($tipoForm == 1){
                    $planillas = $planilla_repo->findByAnoMesTipoFuente($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                }elseif($tipoForm == 2){
                    $planillas = $planilla_repo->findBy(["id" => $planillaForm]);
                }
            } else {
                $status = "La consulta no pudo procesarse, porque el formulario no es válido!!";
            }
            if (isset($status)) {
                $this->session->getFlashBag()->add("status", $status);
            }
            return $this->render("PlanillaBundle:planilla:reporte.html.php", [
                        "planillas" => $planillas,
                        "tipoPlanilla" => $tipoPlanilla,
                        "anoEje" => $anoEjeForm,
                        "mesEje" => $mesEjeForm,
                        "fuente" => $fuenteFinanc
            ]);
        }
        return $this->render("@Planilla/planilla/reporte.html.twig", [
                    "form" => $form->createView()
        ]);
    }

    public function modifyPlazaHistorialAction(Request $request) {
        $tipoPlanilla_id = $request->query->get("tipoPlanilla");
        $em = $this->getDoctrine()->getManager();
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);

        $tipoPlanilla = $em->getRepository('PlanillaBundle:TipoPlanilla')->find(['id' => $tipoPlanilla_id]);
        $plazaHistoriales = $em->getRepository('PlanillaBundle:PlazaHistorial')->findArrayByTipoPlanillaAnoEjeMesEje($tipoPlanilla, $anoEje, $mesEje);
        return new JsonResponse($plazaHistoriales);
    }

    public function modifyFuenteAction(Request $request) {
        $anoEje = $request->query->get("anoEje");
        $em = $this->getDoctrine()->getManager();
        $fuentes = $em->getRepository('PlanillaBundle:FuenteFinanc')->findArrayByAnoEje($anoEje);
        return new JsonResponse($fuentes);
    }

    public function modifyPlanillaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $anoEje = $request->query->get("anoEje");
        $mesEjeId = $request->query->get("mesEje");
        $mesEje = $em->getRepository('PlanillaBundle:Mes')->findOneBy(["mesEje" => $mesEjeId]);
        $tipoPlanillaId = $request->query->get("tipoPlanilla");
        $tipoPlanilla = $em->getRepository('PlanillaBundle:TipoPlanilla')->findOneBy(["id" => $tipoPlanillaId]);
        $fuenteId = $request->query->get("fuente");
        $fuente = $em->getRepository('PlanillaBundle:FuenteFinanc')->findOneBy(["id" => $fuenteId]);
        $tipoId = $request->query->get("tipo");
        if ($tipoId == 2) {
            
            $fuentes = $em->getRepository('PlanillaBundle:Planilla')->findArrayByAnoMesTipoFuente($anoEje, $mesEje, $tipoPlanilla, $fuente);
        } else {
            $fuentes = [["id" => 0, "nombre" => "TODOS"]];
        }
        return new JsonResponse($fuentes);
    }

}

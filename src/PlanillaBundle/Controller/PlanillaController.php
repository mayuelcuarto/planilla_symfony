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
use PlanillaBundle\Form\PlanillaMetaType;
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
            'fuentes' => $fuentes,
            'btnSubmit' => "Buscar"
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

                    $tipoPlanilla = $planilla->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getNombre();
                    $numPlaza = $planilla->getPlazaHistorial()->getPlaza()->getNumPlaza();

                    $em->persist($planilla);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La planilla $tipoPlanilla $numPlaza se ha creado correctamente";
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

                $tipoPlanilla = $planilla->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getNombre();
                $numPlaza = $planilla->getPlazaHistorial()->getPlaza()->getNumPlaza();

                $em->persist($planilla);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La planilla $tipoPlanilla $numPlaza se ha editado correctamente";
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

        if ($mesEje->getMesEje() == 1) {
            $anoEjeOrigen = $anoEje - 1;
            $mesEjeOrigen = $mes_repo->findOneBy(["mesEje" => 12]);
        } else {
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
            'fuentes' => $fuentes,
            'btnSubmit' => "Imprimir"
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
                $status = "El reporte no pudo generarse, porque el formulario no es válido!!";
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

    public function resumenAction(Request $request) {
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
            'fuentes' => $fuentes,
            'btnSubmit' => "Imprimir"
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $anoEjeForm = $form->get("anoEje")->getData();
                $mesEjeForm = $form->get("mesEje")->getData();
                $fuenteFinanc = $form->get("fuente")->getData();

                $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
                $planillaHasConcepto_repo = $em->getRepository("PlanillaBundle:PlanillaHasConcepto");
                $concepto_repo = $em->getRepository("PlanillaBundle:Concepto");

                //$planillas = $planilla_repo->findByAnoMesTipoFuente($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $conceptos = $concepto_repo->findAll();
                $arrayConcepto = Array();
                foreach ($conceptos as $concepto) {
                    $arrayConcepto[$concepto->getId()]['abreviatura'] = $concepto->getAbreviatura();
                    $arrayConcepto[$concepto->getId()]['tipo'] = $concepto->getTipoConcepto()->getId();
                    $arrayConcepto[$concepto->getId()]['monto'] = $planillaHasConcepto_repo->sumaConcepto($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc, $concepto);
                }

                $sumaRemAseg = $planilla_repo->SumaRemAseg($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaRemNoAseg = $planilla_repo->SumaRemNoAseg($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaTotalEgreso = $planilla_repo->SumaTotalEgreso($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                $sumaPatronal = $planilla_repo->SumaPatronal($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
            } else {
                $status = "El reporte no pudo generarse, porque el formulario no es válido!!";
            }
            if (isset($status)) {
                $this->session->getFlashBag()->add("status", $status);
            }
            return $this->render("PlanillaBundle:planilla:reporteResumen.html.php", [
                        "conceptos" => $arrayConcepto,
                        "sumaRemAseg" => $sumaRemAseg,
                        "sumaRemNoAseg" => $sumaRemNoAseg,
                        "sumaTotalEgreso" => $sumaTotalEgreso,
                        "sumaPatronal" => $sumaPatronal,
                        "tipoPlanilla" => $tipoPlanilla,
                        "anoEje" => $anoEjeForm,
                        "mesEje" => $mesEjeForm,
                        "fuente" => $fuenteFinanc
            ]);
        }

        return $this->render("@Planilla/planilla/resumen.html.twig", [
                    "form" => $form->createView()
        ]);
    }

    public function metasAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);
        $tipoPlanilla_repo = $em->getRepository("PlanillaBundle:TipoPlanilla");
        $tipoPlanilla = $tipoPlanilla_repo->findOneBy(["id" => 1]);
        $especifica_repo = $em->getRepository("PlanillaBundle:Especifica");
        $especificas1 = $especifica_repo->findArrayByAnoMesTP($anoEje, $mesEje, $tipoPlanilla);
        //var_dump($especificas1);
        $especificas = Array();
        foreach ($especificas1 as $especifica) {
            $especificas[$especifica['especifica'] . " " . $especifica["nombre"]] = $especifica['id'];
        }

        //var_dump($especificas);

        $planilla = new Planilla();
        for ($i = 2008; $i <= $anoEje; $i++) {
            $anoArray[$i] = $i;
        }

        $form = $this->createForm(PlanillaMetaType::class, $planilla, [
            'anoEje' => $anoEje,
            'mesEje' => $mesEje,
            'anoArray' => $anoArray,
            'especificas' => $especificas,
            'btnSubmit' => 'Imprimir'
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $anoEjeForm = $form->get("anoEje")->getData();
                $mesEjeForm = $form->get("mesEje")->getData();
                $especificaForm = $form->get("especifica")->getData();
                $especifica = $em->getRepository("PlanillaBundle:Especifica")->findOneBy(["id" => $especificaForm]);

                $planillaHasConcepto_repo = $em->getRepository("PlanillaBundle:PlanillaHasConcepto");
                $meta_repo = $em->getRepository("PlanillaBundle:Meta");
                $metas = $meta_repo->findDistinctMetasEsp($anoEjeForm, $mesEjeForm, $especifica);
                $concepto_repo = $em->getRepository("PlanillaBundle:Concepto");
                $tipoConcepto1 = $em->getRepository("PlanillaBundle:TipoConcepto")->findOneBy(["id" => 1]);
                $tipoConcepto2 = $em->getRepository("PlanillaBundle:TipoConcepto")->findOneBy(["id" => 2]);
                $conceptos1 = $concepto_repo->findDistinctMetasEspTC($anoEjeForm, $mesEjeForm, $especifica, $tipoConcepto1);
                $conceptos2 = $concepto_repo->findDistinctMetasEspTC($anoEjeForm, $mesEjeForm, $especifica, $tipoConcepto2);

                $arrayMetas1 = Array();
                $arrayConceptos1 = Array();
                $totalesMetas1 = Array();
                $totalesConceptos1 = Array();
                
                foreach ($metas as $meta) {
                    $arrayMetas1[$meta['secfunc']]['secfunc'] = $meta['secfunc'];
                    $meta2 = $meta_repo->findOneBy(["secFunc" => $meta['secfunc']]);
                    $arrayMetas1[$meta['secfunc']]['meta'] = $meta['actProy'] . " " . $meta['nombre'];
                    $suma = 0;
                    foreach ($conceptos1 as $concepto) {
                        $arrayConceptos1[$concepto['id']]['id'] = $concepto['id'];
                        $arrayConceptos1[$concepto['id']]['concepto'] = $concepto['concepto'];
                        $arrayConceptos1[$concepto['id']]['abreviatura'] = $concepto['abreviatura'];
                        $conceptoAux = $concepto_repo->findOneBy(["id" => $concepto['id']]);
                        $arrayConceptos1[$concepto['id']]['monto'] = $planillaHasConcepto_repo->sumaConceptoMetaEsp($anoEjeForm, $mesEjeForm, $tipoPlanilla, $meta2, $especifica, $conceptoAux);
                        $arrayMetas1[$meta['secfunc']]['conceptos'] = $arrayConceptos1;
                        
                        $suma += $arrayConceptos1[$concepto['id']]['monto'];
                    }
                    $totalesMetas1[$meta['secfunc']]['total'] = $suma;
                }
                
                foreach ($conceptos1 as $concepto){
                    $conceptoAux = $concepto_repo->findOneBy(["id" => $concepto['id']]);
                    $totalesConceptos1[$concepto['id']]['total'] = $planillaHasConcepto_repo->sumaConceptoEsp($anoEjeForm, $mesEjeForm, $tipoPlanilla, $especifica, $conceptoAux);
                }

                $arrayMetas2 = Array();
                $arrayConceptos2 = Array();
                $totalesMetas2 = Array();
                $totalesConceptos2 = Array();
                
                foreach ($metas as $meta) {
                    $arrayMetas2[$meta['secfunc']]['secfunc'] = $meta['secfunc'];
                    $meta2 = $meta_repo->findOneBy(["secFunc" => $meta['secfunc']]);
                    $arrayMetas2[$meta['secfunc']]['meta'] = $meta['actProy'] . " " . $meta['nombre'];
                    $suma = 0;
                    foreach ($conceptos2 as $concepto) {
                        $arrayConceptos2[$concepto['id']]['id'] = $concepto['id'];
                        $arrayConceptos2[$concepto['id']]['concepto'] = $concepto['concepto'];
                        $arrayConceptos2[$concepto['id']]['abreviatura'] = $concepto['abreviatura'];
                        $conceptoAux = $concepto_repo->findOneBy(["id" => $concepto['id']]);
                        $arrayConceptos2[$concepto['id']]['monto'] = $planillaHasConcepto_repo->sumaConceptoMetaEsp($anoEjeForm, $mesEjeForm, $tipoPlanilla, $meta2, $especifica, $conceptoAux);
                        $arrayMetas2[$meta['secfunc']]['conceptos'] = $arrayConceptos2;
                        
                        $suma += $arrayConceptos2[$concepto['id']]['monto'];
                    }
                    $totalesMetas2[$meta['secfunc']]['total'] = $suma;
                }
                
                foreach ($conceptos2 as $concepto){
                    $conceptoAux = $concepto_repo->findOneBy(["id" => $concepto['id']]);
                    $totalesConceptos2[$concepto['id']]['total'] = $planillaHasConcepto_repo->sumaConceptoEsp($anoEjeForm, $mesEjeForm, $tipoPlanilla, $especifica, $conceptoAux);
                }

            } else {
                $status = "El reporte no pudo generarse, porque el formulario no es válido!!";
            }
            if (isset($status)) {
                $this->session->getFlashBag()->add("status", $status);
            }
            return $this->render("PlanillaBundle:planilla:reporteMeta.html.php", [
                        "conceptos1" => $conceptos1,
                        "conceptos2" => $conceptos2,
                        "arrayMetas1" => $arrayMetas1,
                        "arrayMetas2" => $arrayMetas2,
                        "totalesMetas1" => $totalesMetas1,
                        "totalesMetas2" => $totalesMetas2,
                        "totalesConceptos1" => $totalesConceptos1,
                        "totalesConceptos2" => $totalesConceptos2,
                        "tipoPlanilla" => $tipoPlanilla,
                        "anoEje" => $anoEjeForm,
                        "mesEje" => $mesEjeForm,
                        "especifica" => $especifica
            ]);
        }

        return $this->render("@Planilla/planilla/metas.html.twig", [
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
            'fuentes' => $fuentes,
            'btnSubmit' => "Imprimir"
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
                if ($tipoForm == 1) {
                    $planillas = $planilla_repo->findByAnoMesTipoFuente($anoEjeForm, $mesEjeForm, $tipoPlanilla, $fuenteFinanc);
                } elseif ($tipoForm == 2) {
                    $planillas = $planilla_repo->findBy(["id" => $planillaForm]);
                }
            } else {
                $status = "El reporte no pudo generarse, porque el formulario no es válido!!";
            }
            if (isset($status)) {
                $this->session->getFlashBag()->add("status", $status);
            }
            return $this->render("PlanillaBundle:planilla:reportePlanilla.html.php", [
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

    public function modifyMetaAction(Request $request) {
        $anoEje = $request->query->get("anoEje");
        $mesEjeId = $request->query->get("mesEje");
        $tipoPlanillaId = $request->query->get("tipoPlanilla");
        $em = $this->getDoctrine()->getManager();
        $mesEje = $em->getRepository('PlanillaBundle:Mes')->findOneBy(["mesEje" => $mesEjeId]);
        $tipoPlanilla = $em->getRepository("PlanillaBundle:TipoPlanilla")->findOneBy(["id" => $tipoPlanillaId]);
        $especificas = $em->getRepository('PlanillaBundle:Especifica')->findArrayByAnoMesTP($anoEje, $mesEje, $tipoPlanilla);
        return new JsonResponse($especificas);
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

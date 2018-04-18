<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\PlanillaHasConcepto;
use PlanillaBundle\Form\PlanillaHasConceptoType;
use PlanillaBundle\Form\PlanillaHasConceptoEditType;
use PlanillaBundle\Form\PlanillaHasConceptoSearchType;
use PlanillaBundle\Form\PlanillaHasConceptoBajaType;

class PlanillaHasConceptoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request, $planillaId) {
        $em = $this->getDoctrine()->getManager();
        $dql = $em->createQuery("SELECT phc FROM PlanillaBundle:PlanillaHasConcepto phc 
                                        INNER JOIN phc.concepto c
                                        WHERE  
                                        phc.planilla = :planillaId
                                        ORDER BY phc.id")
                ->setParameter('planillaId', $planillaId);
        $planillaHasConceptos = $dql->getResult();

        $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
        //$planilla = new \PlanillaBundle\Entity\Planilla;
        $planilla = $planilla_repo->find($planillaId);
        $personal = $planilla->getPlazaHistorial()->getCodPersonal();

        $planillaHasConcepto = new PlanillaHasConcepto();
        $form = $this->createForm(PlanillaHasConceptoSearchType::class, $planillaHasConcepto);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoConcepto = $form->get("tipoConcepto")->getData();

                $dql = $em->createQuery("SELECT phc FROM PlanillaBundle:PlanillaHasConcepto phc 
                                        INNER JOIN phc.concepto c
                                        WHERE  
                                        phc.planilla = :planillaId
                                        ORDER BY phc.id")
                        ->setParameter('planillaId', $planillaId);
                $planillaHasConceptos = $dql->getResult();

                if (count($planillaHasConceptos) == 0) {
                    $status = "La búsqueda no encontró coincidencias";
                } else {
                    $status = "Resultados de la búsqueda, listando " . count($planillaHasConceptos) . " cocnepto(s) de planilla";
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->render("@Planilla/planillaHasConcepto/index.html.twig", [
                        "planillaHasConceptos" => $planillaHasConceptos,
                        "planillaId" => $planillaId,
                        "form" => $form->createView(),
                        "personal" => $personal
            ]);
        }

        return $this->render("@Planilla/planillaHasConcepto/index.html.twig", [
                    "planillaHasConceptos" => $planillaHasConceptos,
                    "planillaId" => $planillaId,
                    "form" => $form->createView(),
                    "personal" => $personal
        ]);
    }

    public function addAction(Request $request, $planillaId, $tipoConcepto) {
        $em = $this->getDoctrine()->getManager();
        $tipoConcepto_repo = $em->getRepository("PlanillaBundle:TipoConcepto");
        $tipoConceptoEn = $tipoConcepto_repo->findOneBy(["id" => $tipoConcepto]);

        $dql = $em->createQuery("SELECT c FROM PlanillaBundle:Concepto c 
                                        WHERE 
                                        c.tipoConcepto = :tipoConcepto  
                                        ORDER BY c.id ")
                ->setParameter('tipoConcepto', $tipoConcepto);
        $conceptos = $dql->getResult();

        $planillaHasConcepto = new PlanillaHasConcepto();
        $form = $this->createForm(PlanillaHasConceptoType::class, $planillaHasConcepto, [
            "conceptos" => $conceptos,
            "tipoConcepto" => $tipoConceptoEn]);


        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
                $planilla = $planilla_repo->findOneBy(["id" => $planillaId]);
                $planillaHasConcepto = new PlanillaHasConcepto();
                $planillaHasConcepto->setPlanilla($planilla);
                $planillaHasConcepto->setConcepto($form->get("concepto")->getData());
                $planillaHasConcepto->setMonto($form->get("monto")->getData());
                $planillaHasConcepto->setFechaIng(new \DateTime('now'));
                $planillaHasConcepto->setUsuario($this->getUser());

                $em->persist($planillaHasConcepto);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "Concepto agregado a planilla correctamente";
                } else {
                    $status = "No te has registrado correctamente";
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planillaHasConcepto_index", ["planillaId" => $planillaId]);
        }
        return $this->render('@Planilla/planillaHasConcepto/add.html.twig', [
                    "form" => $form->createView(),
                    "planillaId" => $planillaId,
                    "tipoConcepto" => $tipoConcepto
        ]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $planillaHasConcepto_repo = $em->getRepository("PlanillaBundle:PlanillaHasConcepto");
        $planillaHasConcepto = $planillaHasConcepto_repo->find($id);

        $form = $this->createForm(PlanillaHasConceptoEditType::class, $planillaHasConcepto);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planillaHasConcepto->setCodPersonal($form->get("codPersonal")->getData());
                $planillaHasConcepto->setRegimenLaboral($form->get("regimenLaboral")->getData());
                $planillaHasConcepto->setCondicionLaboral($form->get("condicionLaboral")->getData());
                $planillaHasConcepto->setModoIngreso($form->get("modoIngreso")->getData());
                $planillaHasConcepto->setResolucion($form->get("resolucion")->getData());
                $planillaHasConcepto->setFechaIngreso($form->get("fechaIngreso")->getData());
                $planillaHasConcepto->setCargo($form->get("cargo")->getData());
                $planillaHasConcepto->setRegimenPensionario($form->get("regimenPensionario")->getData());
                $planillaHasConcepto->setAfp($form->get("afp")->getData());
                $planillaHasConcepto->setAfpMix($form->get("afpMix")->getData());
                $planillaHasConcepto->setFechaAfp($form->get("fechaAfp")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($planillaHasConcepto);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "EL historial de plaza se ha editado correctamente";
                } else {
                    $status = "Error al editar planillaHasConcepto!!";
                }
            } else {
                $status = "EL historial de plaza no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planillaHasConcepto_index", ["id" => $planillaHasConcepto->getPlaza()->getId()]);
        }
        return $this->render('@Planilla/planillaHasConcepto/edit.html.twig', [
                    "form" => $form->createView(),
                    "plazaId" => $planillaHasConcepto->getPlaza()->getId()
        ]);
    }

    public function bajaAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $planillaHasConcepto_repo = $em->getRepository("PlanillaBundle:PlanillaHasConcepto");
        $planillaHasConcepto = $planillaHasConcepto_repo->find($id);

        $form = $this->createForm(PlanillaHasConceptoBajaType::class, $planillaHasConcepto);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planillaHasConcepto->setMotivoAnulacion($form->get("motivoAnulacion")->getData());
                $planillaHasConcepto->setDocAnulacion($form->get("docAnulacion")->getData());
                $planillaHasConcepto->setFechaAnulacion($form->get("fechaAnulacion")->getData());
                $planillaHasConcepto->setEstado(false);

                $em = $this->getDoctrine()->getManager();
                $em->persist($planillaHasConcepto);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "EL historial de plaza se ha dado de baja";
                } else {
                    $status = "Error al dar de baja!!";
                }
            } else {
                $status = "EL historial de plaza no se ha dado de baja, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planillaHasConcepto_index", ["id" => $planillaHasConcepto->getPlaza()->getId()]);
        }
        return $this->render('@Planilla/planillaHasConcepto/baja.html.twig', [
                    "form" => $form->createView(),
                    "plazaId" => $planillaHasConcepto->getPlaza()->getId()
        ]);
    }

}

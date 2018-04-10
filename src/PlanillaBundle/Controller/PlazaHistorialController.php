<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\PlazaHistorial;
use PlanillaBundle\Form\PlazaHistorialType;
use PlanillaBundle\Form\PlazaHistorialEditType;
use PlanillaBundle\Form\PlazaHistorialBajaType;
use PDO;

class PlazaHistorialController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $plazaHistorial_repo = $em->getRepository("PlanillaBundle:PlazaHistorial");
        $plazaHistorials = $plazaHistorial_repo->findBy(['plaza' => $id], ['estado' => 'DESC']);
        $plazaHistorialOn = $plazaHistorial_repo->findBy(['plaza' => $id, 'estado' => true]);
        if ($plazaHistorialOn != null) {
            $activado = false;
        } else {
            $activado = true;
        }

        return $this->render("@Planilla/plazaHistorial/index.html.twig", [
                    "plazaHistorials" => $plazaHistorials,
                    "plazaId" => $id,
                    "activado" => $activado
        ]);
    }

    public function addAction(Request $request, $plazaId) {
        $plazaHistorial = new PlazaHistorial();
        $form = $this->createForm(PlazaHistorialType::class, $plazaHistorial);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $sth1 = $em->getConnection()->prepare("SELECT GenerarSecPlazaHistorial(:plazaId)");
                $sth1->bindValue(':plazaId', $plazaId);
                $sth1->execute();
                while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                    $secPersonal = $fila[0];
                }
                $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
                $plaza = $plaza_repo->findOneBy(["id" => $plazaId]);
                $plazaHistorial = new PlazaHistorial();
                $plazaHistorial->setSecPersonal($secPersonal);
                $plazaHistorial->setPlaza($plaza);
                $plazaHistorial->setCodPersonal($form->get("codPersonal")->getData());
                $plazaHistorial->setRegimenLaboral($form->get("regimenLaboral")->getData());
                $plazaHistorial->setCondicionLaboral($form->get("condicionLaboral")->getData());
                $plazaHistorial->setModoIngreso($form->get("modoIngreso")->getData());
                $plazaHistorial->setResolucion($form->get("resolucion")->getData());
                $plazaHistorial->setFechaIngreso($form->get("fechaIngreso")->getData());
                $plazaHistorial->setCargo($form->get("cargo")->getData());
                $plazaHistorial->setRegimenPensionario($form->get("regimenPensionario")->getData());
                $plazaHistorial->setAfp($form->get("afp")->getData());
                $plazaHistorial->setAfpMix($form->get("afpMix")->getData());
                $plazaHistorial->setFechaAfp($form->get("fechaAfp")->getData());
                $plazaHistorial->setEstado(true);

                $em->persist($plazaHistorial);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "EL historial de plaza se ha creado correctamente";
                } else {
                    $status = "No te has registrado correctamente";
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("plazaHistorial_index", ["id" => $plazaId]);
        }
        return $this->render('@Planilla/plazaHistorial/add.html.twig', [
                    "form" => $form->createView(),
                    "plazaId" => $plazaId
        ]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $plazaHistorial_repo = $em->getRepository("PlanillaBundle:PlazaHistorial");
        $plazaHistorial = $plazaHistorial_repo->find($id);

        $form = $this->createForm(PlazaHistorialEditType::class, $plazaHistorial);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $plazaHistorial->setCodPersonal($form->get("codPersonal")->getData());
                $plazaHistorial->setRegimenLaboral($form->get("regimenLaboral")->getData());
                $plazaHistorial->setCondicionLaboral($form->get("condicionLaboral")->getData());
                $plazaHistorial->setModoIngreso($form->get("modoIngreso")->getData());
                $plazaHistorial->setResolucion($form->get("resolucion")->getData());
                $plazaHistorial->setFechaIngreso($form->get("fechaIngreso")->getData());
                $plazaHistorial->setCargo($form->get("cargo")->getData());
                $plazaHistorial->setRegimenPensionario($form->get("regimenPensionario")->getData());
                $plazaHistorial->setAfp($form->get("afp")->getData());
                $plazaHistorial->setAfpMix($form->get("afpMix")->getData());
                $plazaHistorial->setFechaAfp($form->get("fechaAfp")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($plazaHistorial);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "EL historial de plaza se ha editado correctamente";
                } else {
                    $status = "Error al editar plazaHistorial!!";
                }
            } else {
                $status = "EL historial de plaza no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("plazaHistorial_index", ["id" => $plazaHistorial->getPlaza()->getId()]);
        }
        return $this->render('@Planilla/plazaHistorial/edit.html.twig', [
                    "form" => $form->createView(),
                    "plazaId" => $plazaHistorial->getPlaza()->getId()
        ]);
    }

    public function bajaAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $plazaHistorial_repo = $em->getRepository("PlanillaBundle:PlazaHistorial");
        $plazaHistorial = $plazaHistorial_repo->find($id);

        $form = $this->createForm(PlazaHistorialBajaType::class, $plazaHistorial);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $plazaHistorial->setMotivoAnulacion($form->get("motivoAnulacion")->getData());
                $plazaHistorial->setDocAnulacion($form->get("docAnulacion")->getData());
                $plazaHistorial->setFechaAnulacion($form->get("fechaAnulacion")->getData());
                $plazaHistorial->setEstado(false);

                $em = $this->getDoctrine()->getManager();
                $em->persist($plazaHistorial);
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
            return $this->redirectToRoute("plazaHistorial_index", ["id" => $plazaHistorial->getPlaza()->getId()]);
        }
        return $this->render('@Planilla/plazaHistorial/baja.html.twig', [
                    "form" => $form->createView(),
                    "plazaId" => $plazaHistorial->getPlaza()->getId()
        ]);
    }

}

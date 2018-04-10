<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\FuenteFinanc;
use PlanillaBundle\Form\FuenteFinancType;

class FuenteFinancController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $fuente_repo = $em->getRepository("PlanillaBundle:FuenteFinanc");
        $fuentes = $fuente_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/fuente/index.html.twig", ["fuentes" => $fuentes]);
    }

    public function addAction(Request $request) {
        $fuente = new FuenteFinanc();
        $form = $this->createForm(FuenteFinancType::class, $fuente);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $fuente_repo = $em->getRepository("PlanillaBundle:FuenteFinanc");
                $fuente = $fuente_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "fuenteFinanc" => $form->get("fuenteFinanc")->getData()
                ]);
                if ($fuente != null) {
                    $status = "La fuente de financiamiento ya existe!!!";
                } else {
                    $fuente = new FuenteFinanc();
                    $fuente->setAnoEje($form->get("anoEje")->getData());
                    $fuente->setFuenteFinanc($form->get("fuenteFinanc")->getData());
                    $fuente->setNombre($form->get("nombre")->getData());
                    $fuente->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($fuente);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La fuente de financiamiento se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fuente_index");
        }
        return $this->render('@Planilla/fuente/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $fuente_repo = $em->getRepository("PlanillaBundle:FuenteFinanc");
        $fuente = $fuente_repo->find($id);

        $form = $this->createForm(FuenteFinancType::class, $fuente);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $fuente->setAnoEje($form->get("anoEje")->getData());
                $fuente->setFuenteFinanc($form->get("fuenteFinanc")->getData());
                $fuente->setNombre($form->get("nombre")->getData());
                $fuente->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($fuente);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La fuente de financiamiento se ha editado correctamente";
                } else {
                    $status = "Error al editar fuente de financiamiento!!";
                }
            } else {
                $status = "La fuente de financiamiento no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("fuente_index");
        }
        return $this->render('@Planilla/fuente/edit.html.twig', ["form" => $form->createView()]);
    }

}

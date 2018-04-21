<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Especifica;
use PlanillaBundle\Form\EspecificaType;

class EspecificaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $especificas = $em->getRepository("PlanillaBundle:Especifica")->findAll();
        return $this->render("@Planilla/especifica/index.html.twig", ["especificas" => $especificas]);
    }

    public function addAction(Request $request) {
        $especifica = new Especifica();
        $form = $this->createForm(EspecificaType::class, $especifica, ["estado" => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $especifica_repo = $em->getRepository("PlanillaBundle:Especifica");
                $especifica = $especifica_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "especifica" => $form->get("especifica")->getData()
                ]);
                if ($especifica != null) {
                    $status = "La específica ya existe!!!";
                } else {
                    $especifica = new Especifica();
                    $especifica->setAnoEje($form->get("anoEje")->getData());
                    $especifica->setEspecifica($form->get("especifica")->getData());
                    $especifica->setNombre($form->get("nombre")->getData());
                    $especifica->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($especifica);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La específica se ha creado correctamente";
                    } else {
                        $status = "Error al agregar específica!!";
                    }
                }
            } else {
                $status = "La específica no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("especifica_index");
        }
        return $this->render('@Planilla/especifica/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $especifica_repo = $em->getRepository("PlanillaBundle:Especifica");
        $especifica = $especifica_repo->find($id);
        $form = $this->createForm(EspecificaType::class, $especifica, ["estado" => $especifica->getEstado()]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $especifica->setAnoEje($form->get("anoEje")->getData());
                $especifica->setEspecifica($form->get("especifica")->getData());
                $especifica->setNombre($form->get("nombre")->getData());
                $especifica->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($especifica);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La específica se ha editado correctamente";
                } else {
                    $status = "Error al editar específica!!";
                }
            } else {
                $status = "La específica no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("especifica_index");
        }
        return $this->render('@Planilla/especifica/edit.html.twig', ["form" => $form->createView()]);
    }

}

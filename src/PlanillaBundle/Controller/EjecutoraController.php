<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Ejecutora;
use PlanillaBundle\Form\EjecutoraType;
use PlanillaBundle\Form\EjecutoraEditType;

class EjecutoraController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $ejecutoras = $em->getRepository("PlanillaBundle:Ejecutora")->findAll();
        return $this->render("@Planilla/ejecutora/index.html.twig", ["ejecutoras" => $ejecutoras]);
    }

    public function addAction(Request $request) {
        $ejecutora = new Ejecutora();
        $form = $this->createForm(EjecutoraType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $ejecutora_repo = $em->getRepository("PlanillaBundle:Ejecutora");
                $ejecutora = $ejecutora_repo->findOneBy([
                    "pliego" => $form->get("pliego")->getData(),
                    "secEjec" => $form->get("secEjec")->getData()
                ]);
                if ($ejecutora != null) {
                    $status = "La ejecutora ya existe!!!";
                } else {
                    $ejecutora = new Ejecutora();
                    $ejecutora->setPliego($form->get("pliego")->getData());
                    $ejecutora->setSecEjec($form->get("secEjec")->getData());
                    $ejecutora->setNombre($form->get("nombre")->getData());
                    $ejecutora->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($ejecutora);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La ejecutora se ha creado correctamente";
                    } else {
                        $status = "Error al agregar ejecutora!!";
                    }
                }
            } else {
                $status = "La ejecutora no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("ejecutora_index");
        }
        return $this->render('@Planilla/ejecutora/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $ejecutora_repo = $em->getRepository("PlanillaBundle:Ejecutora");
        $ejecutora = $ejecutora_repo->find($id);
        $form = $this->createForm(EjecutoraEditType::class, $ejecutora);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $ejecutora->setPliego($form->get("pliego")->getData());
                $ejecutora->setSecEjec($form->get("secEjec")->getData());
                $ejecutora->setNombre($form->get("nombre")->getData());
                $ejecutora->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($ejecutora);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La ejecutora se ha editado correctamente";
                } else {
                    $status = "Error al editar ejecutora!!";
                }
            } else {
                $status = "La ejecutora no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("ejecutora_index");
        }
        return $this->render('@Planilla/ejecutora/edit.html.twig', ["form" => $form->createView()]);
    }

}

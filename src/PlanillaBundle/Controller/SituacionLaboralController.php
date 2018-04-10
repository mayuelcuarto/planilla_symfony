<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\SituacionLaboral;
use PlanillaBundle\Form\SituacionLaboralType;

class SituacionLaboralController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $situacionLaboral_repo = $em->getRepository("PlanillaBundle:SituacionLaboral");
        $situacionLaborals = $situacionLaboral_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/situacionLaboral/index.html.twig", ["situacionLaborals" => $situacionLaborals]);
    }

    public function addAction(Request $request) {
        $situacionLaboral = new SituacionLaboral();
        $form = $this->createForm(SituacionLaboralType::class, $situacionLaboral);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $situacionLaboral_repo = $em->getRepository("PlanillaBundle:SituacionLaboral");
                $situacionLaboral = $situacionLaboral_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($situacionLaboral != null) {
                    $status = "La situación laboral ya existe!!!";
                } else {
                    $situacionLaboral = new SituacionLaboral();
                    $situacionLaboral->setNombre($form->get("nombre")->getData());
                    $situacionLaboral->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($situacionLaboral);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La situación laboral se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("situacionLaboral_index");
        }
        return $this->render('@Planilla/situacionLaboral/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $situacionLaboral_repo = $em->getRepository("PlanillaBundle:SituacionLaboral");
        $situacionLaboral = $situacionLaboral_repo->find($id);

        $form = $this->createForm(SituacionLaboralType::class, $situacionLaboral);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $situacionLaboral->setNombre($form->get("nombre")->getData());
                $situacionLaboral->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($situacionLaboral);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La situación laboral se ha editado correctamente";
                } else {
                    $status = "Error al editar situación laboral!!";
                }
            } else {
                $status = "La situación laboral no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("situacionLaboral_index");
        }
        return $this->render('@Planilla/situacionLaboral/edit.html.twig', ["form" => $form->createView()]);
    }

}

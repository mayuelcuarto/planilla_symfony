<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\CondicionLaboral;
use PlanillaBundle\Form\CondicionLaboralType;
use PlanillaBundle\Form\CondicionLaboralEditType;
use PDO;

class CondicionLaboralController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $condicionLaboral_repo = $em->getRepository("PlanillaBundle:CondicionLaboral");
        $condicionLaborals = $condicionLaboral_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/condicionLaboral/index.html.twig", ["condicionLaborals" => $condicionLaborals]);
    }

    public function addAction(Request $request) {
        $condicionLaboral = new CondicionLaboral();
        $em = $this->getDoctrine()->getManager();
        $id = $em->getRepository("PlanillaBundle:CondicionLaboral")->sugerirCondicionLaboral();
        $form = $this->createForm(CondicionLaboralType::class, $condicionLaboral,["id" => $id, "estado" => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $condicionLaboral_repo = $em->getRepository("PlanillaBundle:CondicionLaboral");
                $condicionLaboral = $condicionLaboral_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($condicionLaboral != null) {
                    $status = "La condición laboral ya existe!!!";
                } else {
                    $condicionLaboral = new CondicionLaboral();
                    $condicionLaboral->setId($form->get("id")->getData());
                    $condicionLaboral->setNombre($form->get("nombre")->getData());
                    $condicionLaboral->setEstado($form->get("estado")->getData());
                    $condicionLaboral_repo->AgregarCondicionLaboral($condicionLaboral);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La condición laboral se ha creado correctamente";
                    } else {
                        $status = "Error al agregar condición laboral!!";
                    }
                }
            } else {
                $status = "La condición laboral no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("condicionLaboral_index");
        }
        return $this->render('@Planilla/condicionLaboral/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $condicionLaboral_repo = $em->getRepository("PlanillaBundle:CondicionLaboral");
        $condicionLaboral = $condicionLaboral_repo->find($id);

        $form = $this->createForm(CondicionLaboralEditType::class, $condicionLaboral);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $condicionLaboral->setNombre($form->get("nombre")->getData());
                $condicionLaboral->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($condicionLaboral);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La condición laboral se ha editado correctamente";
                } else {
                    $status = "Error al editar condición laboral!!";
                }
            } else {
                $status = "La condición laboral no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("condicionLaboral_index");
        }
        return $this->render('@Planilla/condicionLaboral/edit.html.twig', ["form" => $form->createView()]);
    }

}

<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Sexo;
use PlanillaBundle\Form\SexoType;

class SexoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $sexo_repo = $em->getRepository("PlanillaBundle:Sexo");
        $sexos = $sexo_repo->findAll();

        return $this->render("@Planilla/sexo/index.html.twig", ["sexos" => $sexos]);
    }

    public function addAction(Request $request) {
        $sexo = new Sexo();
        $form = $this->createForm(SexoType::class, $sexo, ["estado" => true]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $sexo_repo = $em->getRepository("PlanillaBundle:Sexo");
                $sexo = $sexo_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($sexo != null) {
                    $status = "El sexo ya existe!!!";
                } else {
                    $sexo = new Sexo();
                    $sexo->setNombre($form->get("nombre")->getData());
                    $sexo->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sexo);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El sexo se ha creado correctamente";
                    } else {
                        $status = "Error al agregar sexo!!";
                    }
                }
            } else {
                $status = "El sexo no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("sexo_index");
        }
        return $this->render('@Planilla/sexo/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $sexo_repo = $em->getRepository("PlanillaBundle:Sexo");
        $sexo = $sexo_repo->find($id);

        $form = $this->createForm(SexoType::class, $sexo, ["estado" => $sexo->getEstado()]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $sexo->setNombre($form->get("nombre")->getData());
                $sexo->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($sexo);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El sexo se ha editado correctamente";
                } else {
                    $status = "Error al editar sexo!!";
                }
            } else {
                $status = "El sexo no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("sexo_index");
        }
        return $this->render('@Planilla/sexo/edit.html.twig', ["form" => $form->createView()]);
    }

}

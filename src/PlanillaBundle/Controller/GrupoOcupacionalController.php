<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\GrupoOcupacional;
use PlanillaBundle\Form\GrupoOcupacionalType;
use PlanillaBundle\Form\GrupoOcupacionalEditType;
use PDO;

class GrupoOcupacionalController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $grupoOcupacionals = $em->getRepository("PlanillaBundle:GrupoOcupacional")->findAll();
        return $this->render("@Planilla/grupoOcupacional/index.html.twig", ["grupoOcupacionals" => $grupoOcupacionals]);
    }

    public function addAction(Request $request) {
        $grupoOcupacional = new GrupoOcupacional();
        $em = $this->getDoctrine()->getManager();
        $id = $em->getRepository("PlanillaBundle:GrupoOcupacional")->sugerirGrupoOcupacional();
        $form = $this->createForm(GrupoOcupacionalType::class, $grupoOcupacional, ["id" => $id]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $grupoOcupacional_repo = $em->getRepository("PlanillaBundle:GrupoOcupacional");
                $grupoOcupacional = $grupoOcupacional_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($grupoOcupacional != null) {
                    $status = "El grupo ocupacional ya existe!!!";
                } else {
                    $grupoOcupacional = new GrupoOcupacional();
                    $grupoOcupacional->setGrupoOcupacional($form->get("id")->getData());
                    $grupoOcupacional->setNombre($form->get("nombre")->getData());
                    $grupoOcupacional->setEstado($form->get("estado")->getData());

                    $grupoOcupacional_repo->AgregarGrupoOcupacional($grupoOcupacional);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El grupo ocupacional se ha creado correctamente";
                    } else {
                        $status = "Error al agregar grupo ocupacional!!";
                    }
                }
            } else {
                $status = "El grupo ocupacional no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grupoOcupacional_index");
        }
        return $this->render('@Planilla/grupoOcupacional/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $grupoOcupacional_repo = $em->getRepository("PlanillaBundle:GrupoOcupacional");
        $grupoOcupacional = $grupoOcupacional_repo->find($id);
        $form = $this->createForm(GrupoOcupacionalEditType::class, $grupoOcupacional);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $grupoOcupacional->setNombre($form->get("nombre")->getData());
                $grupoOcupacional->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($grupoOcupacional);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El grupo ocupacional se ha editado correctamente";
                } else {
                    $status = "Error al editar grupo ocupacional!!";
                }
            } else {
                $status = "El grupo ocupacional no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grupoOcupacional_index");
        }
        return $this->render('@Planilla/grupoOcupacional/edit.html.twig', ["form" => $form->createView()]);
    }

}

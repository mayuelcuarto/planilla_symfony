<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Grpf;
use PlanillaBundle\Form\GrpfType;
use PlanillaBundle\Form\GrpfEditType;

class GrpfController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $grpfs = $em->getRepository("PlanillaBundle:Grpf")->findAll();
        return $this->render("@Planilla/grpf/index.html.twig", ["grpfs" => $grpfs]);
    }

    public function addAction(Request $request) {
        $anoEje = \date("Y");
        $grpf = new Grpf();
        $form = $this->createForm(GrpfType::class, $grpf, ["estado" => true, "anoEje" => $anoEje]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $grpf_repo = $em->getRepository("PlanillaBundle:Grpf");
                $grpf = $grpf_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "grpf" => $form->get("grpf")->getData()
                ]);
                if ($grpf != null) {
                    $status = "El grupo funcional ya existe!!!";
                } else {
                    $grpf = new Grpf();
                    $grpf->setAnoEje($form->get("anoEje")->getData());
                    $grpf->setGrpf($form->get("grpf")->getData());
                    $grpf->setNombre($form->get("nombre")->getData());
                    $grpf->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($grpf);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El grupo funcional se ha creado correctamente";
                    } else {
                        $status = "Error al agregar grupo funcional!!";
                    }
                }
            } else {
                $status = "El grupo funcional no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grpf_index");
        }
        return $this->render('@Planilla/grpf/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $grpf_repo = $em->getRepository("PlanillaBundle:Grpf");
        $grpf = $grpf_repo->find($id);
        $grpf_aux = $grpf;
        $form = $this->createForm(GrpfEditType::class, $grpf);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $grpf2 = $grpf_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "grpf" => $form->get("grpf")->getData()
                ]);
                if ($grpf2 != null and $grpf2 != $grpf_aux) {
                    $status = "El grupo funcional ya existe!!!";
                } else {
                    $grpf->setAnoEje($form->get("anoEje")->getData());
                    $grpf->setGrpf($form->get("grpf")->getData());
                    $grpf->setNombre($form->get("nombre")->getData());
                    $grpf->setEstado($form->get("estado")->getData());
                    $em->persist($grpf);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El grupo funcional se ha editado correctamente";
                    } else {
                        $status = "Error al editar grupo funcional!!";
                    }
                }
            } else {
                $status = "El grupo funcional no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grpf_index");
        }
        return $this->render('@Planilla/grpf/edit.html.twig', ["form" => $form->createView()]);
    }

}

<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Afp;
use PlanillaBundle\Form\AfpType;
use PlanillaBundle\Form\AfpEditType;

class AfpController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $afps = $em->getRepository("PlanillaBundle:Afp")->findAll();
        return $this->render("@Planilla/afp/index.html.twig", ["afps" => $afps]);
    }

    public function addAction(Request $request) {
        $afp = new Afp();
        $em = $this->getDoctrine()->getManager();
        $id = $em->getRepository("PlanillaBundle:Afp")->sugerirAfp();
        $form = $this->createForm(AfpType::class, $afp, ['id' => $id]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $afp_repo = $em->getRepository("PlanillaBundle:Afp");
                $afp = $afp_repo->findOneBy(["id" => $form->get("id")->getData()]);
                if ($afp != null) {
                    $status = "La afp ya existe!!!";
                } else {
                    $afp = new Afp();
                    $afp->setId($form->get("id")->getData());
                    $afp->setNombre($form->get("nombre")->getData());
                    $afp->setEstado($form->get("estado")->getData());
                    $afp->setRegimenPensionario($form->get("regimenPensionario")->getData());
                    $afp->setSnp($form->get("snp")->getData());
                    $afp->setJubilacion($form->get("jubilacion")->getData());
                    $afp->setSeguros($form->get("seguros")->getData());
                    $afp->setRa($form->get("ra")->getData());
                    $afp->setPension($form->get("pension")->getData());
                    $afp->setRaMixta($form->get("raMixta")->getData());
                    $afp->setEstado($form->get("estado")->getData());
                    
                    $afp_repo->AgregarAfp($afp);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La afp se ha creado correctamente";
                    } else {
                        $status = "Error al agregar afp!!";
                    }
                }
            } else {
                $status = "La afp no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("afp_index");
        }
        return $this->render('@Planilla/afp/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $afp_repo = $em->getRepository("PlanillaBundle:Afp");
        $afp = $afp_repo->find($id);

        $form = $this->createForm(AfpEditType::class, $afp);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $afp->setNombre($form->get("nombre")->getData());
                $afp->setEstado($form->get("estado")->getData());
                $afp->setRegimenPensionario($form->get("regimenPensionario")->getData());
                $afp->setSnp($form->get("snp")->getData());
                $afp->setJubilacion($form->get("jubilacion")->getData());
                $afp->setSeguros($form->get("seguros")->getData());
                $afp->setRa($form->get("ra")->getData());
                $afp->setPension($form->get("pension")->getData());
                $afp->setRaMixta($form->get("raMixta")->getData());

                $em->persist($afp);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La afp se ha editado correctamente";
                } else {
                    $status = "Error al editar afp!!";
                }
            } else {
                $status = "La afp no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("afp_index");
        }
        return $this->render('@Planilla/afp/edit.html.twig', ["form" => $form->createView()]);
    }

}

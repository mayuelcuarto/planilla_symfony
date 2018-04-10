<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Sector;
use PlanillaBundle\Form\SectorType;

class SectorController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $sector_repo = $em->getRepository("PlanillaBundle:Sector");
        $sectores = $sector_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/sector/index.html.twig", ["sectores" => $sectores]);
    }

    public function addAction(Request $request) {
        $sector = new Sector();
        $form = $this->createForm(SectorType::class, $sector);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $sector_repo = $em->getRepository("PlanillaBundle:Sector");
                $sector = $sector_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "sector" => $form->get("sector")->getData()
                ]);
                if ($sector != null) {
                    $status = "El sector ya existe!!!";
                } else {
                    $sector = new Sector();
                    $sector->setAnoEje($form->get("anoEje")->getData());
                    $sector->setSector($form->get("sector")->getData());
                    $sector->setNombre($form->get("nombre")->getData());
                    $sector->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sector);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El sector se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("sector_index");
        }
        return $this->render('@Planilla/sector/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $sector_repo = $em->getRepository("PlanillaBundle:Sector");
        $sector = $sector_repo->find($id);

        $form = $this->createForm(SectorType::class, $sector);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $sector->setAnoEje($form->get("anoEje")->getData());
                $sector->setSector($form->get("sector")->getData());
                $sector->setNombre($form->get("nombre")->getData());
                $sector->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($sector);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El sector se ha editado correctamente";
                } else {
                    $status = "Error al editar sector!!";
                }
            } else {
                $status = "El sector no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("sector_index");
        }
        return $this->render('@Planilla/sector/edit.html.twig', ["form" => $form->createView()]);
    }

}

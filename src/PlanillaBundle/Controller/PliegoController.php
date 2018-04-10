<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Pliego;
use PlanillaBundle\Form\PliegoType;
use PlanillaBundle\Form\PliegoEditType;

class PliegoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $pliego_repo = $em->getRepository("PlanillaBundle:Pliego");
        $pliegos = $pliego_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/pliego/index.html.twig", ["pliegos" => $pliegos]);
    }

    public function addAction(Request $request) {
        $pliego = new Pliego();
        $form = $this->createForm(PliegoType::class, $pliego);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $pliego_repo = $em->getRepository("PlanillaBundle:Pliego");
                $pliego = $pliego_repo->findOneBy([
                    "sector" => $form->get("sector")->getData(),
                    "pliego" => $form->get("pliego")->getData()
                ]);
                if ($pliego != null) {
                    $status = "El pliego ya existe!!!";
                } else {
                    $pliego = new Pliego();
                    $pliego->setSector($form->get("sector")->getData());
                    $pliego->setPliego($form->get("pliego")->getData());
                    $pliego->setNombre($form->get("nombre")->getData());
                    $pliego->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($pliego);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El pliego se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("pliego_index");
        }
        return $this->render('@Planilla/pliego/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $pliego_repo = $em->getRepository("PlanillaBundle:Pliego");
        $pliego = $pliego_repo->find($id);

        $form = $this->createForm(PliegoEditType::class, $pliego);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $pliego->setSector($form->get("sector")->getData());
                $pliego->setPliego($form->get("pliego")->getData());
                $pliego->setNombre($form->get("nombre")->getData());
                $pliego->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($pliego);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El pliego se ha editado correctamente";
                } else {
                    $status = "Error al editar pliego!!";
                }
            } else {
                $status = "El pliego no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("pliego_index");
        }
        return $this->render('@Planilla/pliego/edit.html.twig', ["form" => $form->createView()]);
    }

}

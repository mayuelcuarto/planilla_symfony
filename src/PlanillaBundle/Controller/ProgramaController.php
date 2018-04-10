<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Programa;
use PlanillaBundle\Form\ProgramaType;

class ProgramaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $programa_repo = $em->getRepository("PlanillaBundle:Programa")->createQueryBuilder('p')
                ->where('p.anoEje > :anoEje')
                ->setParameter('anoEje', 2010)
                ->addOrderBy('p.estado', 'DESC')
                ->addOrderBy('p.id', 'ASC')
                ->getQuery()
                ->getResult();
        $programas = $programa_repo;

        return $this->render("@Planilla/programa/index.html.twig", ["programas" => $programas]);
    }

    public function addAction(Request $request) {
        $programa = new Programa();
        $form = $this->createForm(ProgramaType::class, $programa);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $programa_repo = $em->getRepository("PlanillaBundle:Programa");
                $programa = $programa_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "programa" => $form->get("programa")->getData()
                ]);
                if ($programa != null) {
                    $status = "El programa ya existe!!!";
                } else {
                    $programa = new Programa();
                    $programa->setAnoEje($form->get("anoEje")->getData());
                    $programa->setPrograma($form->get("programa")->getData());
                    $programa->setNombre($form->get("nombre")->getData());
                    $programa->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($programa);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El programa se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("programa_index");
        }
        return $this->render('@Planilla/programa/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $programa_repo = $em->getRepository("PlanillaBundle:Programa");
        $programa = $programa_repo->find($id);

        $form = $this->createForm(ProgramaType::class, $programa);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $programa->setAnoEje($form->get("anoEje")->getData());
                $programa->setPrograma($form->get("programa")->getData());
                $programa->setNombre($form->get("nombre")->getData());
                $programa->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($programa);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El programa se ha editado correctamente";
                } else {
                    $status = "Error al editar programa!!";
                }
            } else {
                $status = "El programa no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("programa_index");
        }
        return $this->render('@Planilla/programa/edit.html.twig', ["form" => $form->createView()]);
    }

}

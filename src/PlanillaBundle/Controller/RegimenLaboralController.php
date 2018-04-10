<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\RegimenLaboral;
use PlanillaBundle\Form\RegimenLaboralType;
use PlanillaBundle\Form\RegimenLaboralEditType;
use PDO;

class RegimenLaboralController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $regimenLaboral_repo = $em->getRepository("PlanillaBundle:RegimenLaboral");
        $regimenLaborals = $regimenLaboral_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/regimenLaboral/index.html.twig", ["regimenLaborals" => $regimenLaborals]);
    }

    public function addAction(Request $request) {
        $regimenLaboral = new RegimenLaboral();
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirRegimenLaboral()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id = $fila[0];
        }
        $form = $this->createForm(RegimenLaboralType::class, $regimenLaboral);

        $form->get("id")->setData($id);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $regimenLaboral_repo = $em->getRepository("PlanillaBundle:RegimenLaboral");
                $regimenLaboral = $regimenLaboral_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($regimenLaboral != null) {
                    $status = "El régimen laboral ya existe!!!";
                } else {
                    $regimenLaboral = new RegimenLaboral();
                    $regimenLaboral->setNombre($form->get("nombre")->getData());
                    $regimenLaboral->setDescripcion($form->get("descripcion")->getData());
                    $regimenLaboral->setEstado($form->get("estado")->getData());

                    $id = $form->get("id")->getData();
                    $nombre = $regimenLaboral->getNombre();
                    $descripcion = $regimenLaboral->getDescripcion();
                    $estado = $regimenLaboral->getEstado();

                    $sth = $em->getConnection()->prepare("CALL AgregarRegimenLaboral(:id, :nombre, :descripcion, :estado)");
                    $sth->bindValue(':id', $id);
                    $sth->bindValue(':nombre', $nombre);
                    $sth->bindValue(':descripcion', $descripcion);
                    $sth->bindValue(':estado', $estado);
                    $sth->execute();
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El régimen laboral se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("regimenLaboral_index");
        }
        return $this->render('@Planilla/regimenLaboral/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $regimenLaboral_repo = $em->getRepository("PlanillaBundle:RegimenLaboral");
        $regimenLaboral = $regimenLaboral_repo->find($id);

        $form = $this->createForm(RegimenLaboralEditType::class, $regimenLaboral);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $regimenLaboral->setNombre($form->get("nombre")->getData());
                $regimenLaboral->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($regimenLaboral);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El régimen laboral se ha editado correctamente";
                } else {
                    $status = "Error al editar régimen laboral!!";
                }
            } else {
                $status = "El régimen laboral no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("regimenLaboral_index");
        }
        return $this->render('@Planilla/regimenLaboral/edit.html.twig', ["form" => $form->createView()]);
    }

}

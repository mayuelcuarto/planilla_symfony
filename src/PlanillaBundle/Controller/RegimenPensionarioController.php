<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\RegimenPensionario;
use PlanillaBundle\Form\RegimenPensionarioType;
use PlanillaBundle\Form\RegimenPensionarioEditType;
use PDO;

class RegimenPensionarioController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $regimenPensionario_repo = $em->getRepository("PlanillaBundle:RegimenPensionario");
        $regimenPensionarios = $regimenPensionario_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/regimenPensionario/index.html.twig", ["regimenPensionarios" => $regimenPensionarios]);
    }

    public function addAction(Request $request) {
        $regimenPensionario = new RegimenPensionario();
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirRegimenPensionario()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id = $fila[0];
        }
        $form = $this->createForm(RegimenPensionarioType::class, $regimenPensionario);

        $form->get("id")->setData($id);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $regimenPensionario_repo = $em->getRepository("PlanillaBundle:RegimenPensionario");
                $regimenPensionario = $regimenPensionario_repo->findOneBy(["nombre" => $form->get("nombre")->getData()]);
                if ($regimenPensionario != null) {
                    $status = "El régimen pensionario ya existe!!!";
                } else {
                    $regimenPensionario = new RegimenPensionario();
                    $regimenPensionario->setNombre($form->get("nombre")->getData());
                    $regimenPensionario->setEstado($form->get("estado")->getData());

                    $id = $form->get("id")->getData();
                    $nombre = $regimenPensionario->getNombre();
                    $estado = $regimenPensionario->getEstado();

                    $sth = $em->getConnection()->prepare("CALL AgregarRegimenPensionario(:id, :nombre, :estado)");
                    $sth->bindValue(':id', $id);
                    $sth->bindValue(':nombre', $nombre);
                    $sth->bindValue(':estado', $estado);
                    $sth->execute();
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El régimen pensionario se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("regimenPensionario_index");
        }
        return $this->render('@Planilla/regimenPensionario/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $regimenPensionario_repo = $em->getRepository("PlanillaBundle:RegimenPensionario");
        $regimenPensionario = $regimenPensionario_repo->find($id);

        $form = $this->createForm(RegimenPensionarioEditType::class, $regimenPensionario);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $regimenPensionario->setNombre($form->get("nombre")->getData());
                $regimenPensionario->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($regimenPensionario);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El régimen pensionario se ha editado correctamente";
                } else {
                    $status = "Error al editar régimen pensionario!!";
                }
            } else {
                $status = "El régimen pensionario no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("regimenPensionario_index");
        }
        return $this->render('@Planilla/regimenPensionario/edit.html.twig', ["form" => $form->createView()]);
    }

}

<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Plaza;
use PlanillaBundle\Form\PlazaType;
use PlanillaBundle\Form\PlazaEditType;
use PlanillaBundle\Form\PlazaSearchType;
use Symfony\Component\HttpFoundation\JsonResponse;
use PDO;

class PlazaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
        $plazas = $plaza_repo->findAll();
        
        return $this->render("@Planilla/plaza/index.html.twig", [
                    "plazas" => $plazas
        ]);
    }

    public function addAction(Request $request) {
        $plaza = new Plaza();
        $em = $this->getDoctrine()->getManager();
        /*$sth1 = $em->getConnection()->prepare("SELECT SugerirPlaza(:tipoPlanilla)");
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla);
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $numPlaza = $fila[0];
        }*/

        $tipoPlanilla_repo = $em->getRepository("PlanillaBundle:TipoPlanilla");
        $tipoPlanilla = $tipoPlanilla_repo->findOneBy(["id" => 1]);
        $form = $this->createForm(PlazaType::class, $plaza, ["tipoPlanilla" => $tipoPlanilla]);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
                $plaza = $plaza_repo->findOneBy([
                    "numPlaza" => $form->get("numPlaza")->getData(),
                    "tipoPlanilla" => $form->get("tipoPlanilla")->getData()
                ]);
                if ($plaza != null) {
                    $status = "La plaza ya existe!!!";
                } else {
                    $plaza = new Plaza();
                    $plaza->setTipoPlanilla($form->get("tipoPlanilla")->getData());
                    $plaza->setNumPlaza($form->get("numPlaza")->getData());
                    $plaza->setSecFunc($form->get("secFunc")->getData());
                    $plaza->setEspecifica($form->get("especifica")->getData());
                    $plaza->setCategoria($form->get("categoria")->getData());
                    $plaza->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($plaza);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La plaza se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("plaza_index");
        }
        return $this->render('@Planilla/plaza/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
        $plaza = $plaza_repo->find($id);
        $tipoPlanilla = $plaza->getTipoPlanilla();
        $numPlaza = $plaza->getNumPlaza();
        
        $form = $this->createForm(PlazaEditType::class, $plaza);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $plaza->setTipoPlanilla($tipoPlanilla);
                $plaza->setNumPlaza($numPlaza);
                $plaza->setSecFunc($form->get("secFunc")->getData());
                $plaza->setEspecifica($form->get("especifica")->getData());
                $plaza->setCategoria($form->get("categoria")->getData());
                $plaza->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($plaza);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La plaza ".$plaza->getTipoPlanilla()->getNombre()." ".$plaza->getNumPlaza()." se ha editado correctamente";
                } else {
                    $status = "Error al editar plaza!!";
                }
            } else {
                $status = "La plaza no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("plaza_index");
        }
        return $this->render('@Planilla/plaza/edit.html.twig', ["form" => $form->createView()]);
    }

    public function modifyNumPlazaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirPlaza(:tipoPlanilla)");
        $sth1->bindValue(':tipoPlanilla', $request->query->get("tipoPlanilla"));
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $numPlaza = $fila[0];
        }
        $responseArray = ["numPlaza" => $numPlaza];
        return new JsonResponse($responseArray);
    }

}

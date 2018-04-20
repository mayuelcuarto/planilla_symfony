<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Plaza;
use PlanillaBundle\Form\PlazaType;
use PlanillaBundle\Form\PlazaEditType;
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
        $form = $this->createForm(PlazaType::class, $plaza);
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
                        $status = "Error de persistencia de datos";
                    }
                }
            } else {
                $status = "El formulario no es válido";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("plaza_index");
        }
        return $this->render('@Planilla/plaza/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        //$plaza = new Plaza();
        $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
        $plaza = $plaza_repo->find($id);
        $tipoPlanilla = $plaza->getTipoPlanilla();
        $numPlaza = $plaza->getNumPlaza();
        //Obteniendo datos de grupos ocupacionales
        $dql = $em->createQuery("SELECT g FROM PlanillaBundle:GrupoOcupacional g 
                                        WHERE 
                                        g.estado = 1 OR 
                                        g.grupoOcupacional = :grupo")
                ->setParameter('grupo', $plaza->getCategoria()->getGrupoOcupacional());
        $grupoOcupacional = $dql->getResult();
        
        //Obteniendo datos de categorias ocupacionales
        $dql2 = $em->createQuery("SELECT c FROM PlanillaBundle:CategoriaOcupacional c 
                                        WHERE c.grupoOcupacional = :grupo")
                ->setParameter('grupo', $plaza->getCategoria()->getGrupoOcupacional());
        $categoriaOcupacional = $dql2->getResult();
        
        //Obteniendo datos de metas
        $dql3 = $em->createQuery("SELECT m FROM PlanillaBundle:Meta m 
                                        WHERE 
                                        m.estado = 1 OR 
                                        m.secFunc = :meta")
                ->setParameter('meta', $plaza->getSecFunc());
        $meta = $dql3->getResult();
        
        //Obteniendo datos de especificas
        $dql4 = $em->createQuery("SELECT e FROM PlanillaBundle:Especifica e 
                                        WHERE 
                                        e.estado = 1 OR 
                                        e.id = :especifica")
                ->setParameter('especifica', $plaza->getEspecifica());
        $especifica = $dql4->getResult();
        
        //Construyendo form y enviando parámetros de inicialización
        $form = $this->createForm(PlazaEditType::class, $plaza, [
            "grupoOcupacional" => $grupoOcupacional,
            "grupoSeleccion" => $plaza->getCategoria()->getGrupoOcupacional(),
            "categoriaOcupacional" => $categoriaOcupacional,
            "categoriaSeleccion" => $plaza->getCategoria(),
            "meta" => $meta,
            "metaSeleccion" => $plaza->getSecFunc(),
            "especifica" => $especifica,
            "especificaSeleccion" => $plaza->getEspecifica()
        ]);

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
                    $status = "La plaza " . $plaza->getTipoPlanilla()->getNombre() . " " . $plaza->getNumPlaza() . " se ha editado correctamente";
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

    public function modifyCategoriaAction(Request $request) {
        $grupo_id = $request->query->get("grupo");
        $em = $this->getDoctrine()->getManager();
        $grupo = $em->getRepository('PlanillaBundle:GrupoOcupacional')->find(['grupoOcupacional' => $grupo_id]);
        $query = $em->createQuery("SELECT c FROM PlanillaBundle:CategoriaOcupacional c 
                                   WHERE c.grupoOcupacional = :grupo ")
                ->setParameter('grupo', $grupo);
        $categorias = $query->getArrayResult();
        return new JsonResponse($categorias);
    }

}

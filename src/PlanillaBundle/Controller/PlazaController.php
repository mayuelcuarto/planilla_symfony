<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Plaza;
use PlanillaBundle\Form\PlazaType;
use PlanillaBundle\Form\PlazaSearchType;

class PlazaController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
        $plazas = $plaza_repo->findBy(array(), array('estado' => 'DESC','tipoPlanilla' => 'ASC'));
        
        $plaza = new Plaza();
        $form = $this->createForm(PlazaSearchType::class, $plaza);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                
                $em = $this->getDoctrine()->getManager();
                $plaza_repo = $em->getRepository("PlanillaBundle:Plaza")->createQueryBuilder('p')
                        ->where('p.tipoPlanilla = :tipoPlanilla')
                        ->setParameter('tipoPlanilla', $tipoPlanilla)
                        ->addOrderBy('p.estado', 'DESC')
                        ->addOrderBy('p.numPlaza', 'ASC')
                        ->getQuery()
                        ->getResult();
                $plazas = $plaza_repo;
                if(count($plazas)==0){
                    $status = "La búsqueda no encontró coincidencias";
                }else{
                    $status = "Resultados de la búsqueda, listando ".count($plazas)." plaza(s)";
                }
            } else {
            $status = "No te has registrado correctamente";
        }

            $this->session->getFlashBag()->add("status", $status);
            return $this->render("@Planilla/plaza/index.html.twig", array(
                "plazas" => $plazas,
                "form" => $form->createView()
            ));
        }
        
        return $this->render("@Planilla/plaza/index.html.twig", array(
            "plazas" => $plazas,
            "form" => $form->createView()
        ));
    }
    
    public function addAction(Request $request){
        $plaza = new Plaza();
        $form = $this->createForm(PlazaType::class, $plaza);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
                $plaza = $plaza_repo->findOneBy(array(
                    "numPlaza" => $form->get("numPlaza")->getData(),
                    "tipoPlanilla" => $form->get("tipoPlanilla")->getData()
                        ));
                if($plaza != null){
                    $status = "La plaza ya existe!!!";
                }else{
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
        return $this->render('@Planilla/plaza/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
        $plaza = $plaza_repo->find($id);
        
        $form = $this->createForm(PlazaType::class, $plaza);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
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
                        $status = "La plaza se ha editado correctamente";
                    } else {
                        $status = "Error al editar plaza!!";
                    }
 
            } else {
                $status = "La plaza no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("plaza_index");
        }
        return $this->render('@Planilla/plaza/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

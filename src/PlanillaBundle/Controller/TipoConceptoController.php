<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\TipoConcepto;
use PlanillaBundle\Form\TipoConceptoType;

class TipoConceptoController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $tipoConcepto_repo = $em->getRepository("PlanillaBundle:TipoConcepto");
        $tipoConceptos = $tipoConcepto_repo->findBy(array(), array('estado' => 'DESC','id' => 'ASC'));
        
        return $this->render("@Planilla/tipoConcepto/index.html.twig", array(
            "tipoConceptos" => $tipoConceptos
        ));
    }
    
    public function addAction(Request $request){
        $tipoConcepto = new TipoConcepto();
        $form = $this->createForm(TipoConceptoType::class, $tipoConcepto);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $tipoConcepto_repo = $em->getRepository("PlanillaBundle:TipoConcepto");
                $tipoConcepto = $tipoConcepto_repo->findOneBy(array(
                    "nombre" => $form->get("nombre")->getData()
                        ));
                if($tipoConcepto != null){
                    $status = "El tipo de concepto ya existe!!!";
                }else{
                    $tipoConcepto = new TipoConcepto();
                    $tipoConcepto->setNombre($form->get("nombre")->getData());
                    $tipoConcepto->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tipoConcepto);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El tipo de concepto se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("tipoConcepto_index");
        }
        return $this->render('@Planilla/tipoConcepto/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $tipoConcepto_repo = $em->getRepository("PlanillaBundle:TipoConcepto");
        $tipoConcepto = $tipoConcepto_repo->find($id);
        
        $form = $this->createForm(TipoConceptoType::class, $tipoConcepto);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $tipoConcepto->setNombre($form->get("nombre")->getData());
                    $tipoConcepto->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tipoConcepto);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El tipo de concepto se ha editado correctamente";
                    } else {
                        $status = "Error al editar tipo de concepto!!";
                    }
 
            } else {
                $status = "El tipo de concepto no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("tipoConcepto_index");
        }
        return $this->render('@Planilla/tipoConcepto/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

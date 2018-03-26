<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Divfunc;
use PlanillaBundle\Form\DivfuncType;

class DivfuncController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $divfunc_repo = $em->getRepository("PlanillaBundle:Divfunc");
        $divfuncs = $divfunc_repo->findBy(array(), array('estado' => 'DESC','id' => 'ASC'));
        
        return $this->render("@Planilla/divfunc/index.html.twig", array(
            "divfuncs" => $divfuncs
        ));
    }
    
    public function addAction(Request $request){
        $divfunc = new Divfunc();
        $form = $this->createForm(DivfuncType::class, $divfunc);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $divfunc_repo = $em->getRepository("PlanillaBundle:Divfunc");
                $divfunc = $divfunc_repo->findOneBy(array(
                    "anoEje" => $form->get("anoEje")->getData(),
                    "divfunc" => $form->get("divfunc")->getData()
                        ));
                if($divfunc != null){
                    $status = "El divfunc ya existe!!!";
                }else{
                    $divfunc = new Divfunc();
                    $divfunc->setAnoEje($form->get("anoEje")->getData());
                    $divfunc->setDivfunc($form->get("divfunc")->getData());
                    $divfunc->setNombre($form->get("nombre")->getData());
                    $divfunc->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($divfunc);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El divfunc se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("divfunc_index");
        }
        return $this->render('@Planilla/divfunc/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $divfunc_repo = $em->getRepository("PlanillaBundle:Divfunc");
        $divfunc = $divfunc_repo->find($id);
        
        $form = $this->createForm(DivfuncType::class, $divfunc);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $divfunc->setAnoEje($form->get("anoEje")->getData());
                    $divfunc->setDivfunc($form->get("divfunc")->getData());
                    $divfunc->setNombre($form->get("nombre")->getData());
                    $divfunc->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($divfunc);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El divfunc se ha editado correctamente";
                    } else {
                        $status = "Error al editar divfunc!!";
                    }
 
            } else {
                $status = "El divfunc no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("divfunc_index");
        }
        return $this->render('@Planilla/divfunc/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

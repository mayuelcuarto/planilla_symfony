<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Funcion;
use PlanillaBundle\Form\FuncionType;

class FuncionController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $funcion_repo = $em->getRepository("PlanillaBundle:Funcion");
        $funcions = $funcion_repo->findBy(array(), array('estado' => 'DESC','id' => 'ASC'));
        
        return $this->render("@Planilla/funcion/index.html.twig", array(
            "funcions" => $funcions
        ));
    }
    
    public function addAction(Request $request){
        $funcion = new Funcion();
        $form = $this->createForm(FuncionType::class, $funcion);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $funcion_repo = $em->getRepository("PlanillaBundle:Funcion");
                $funcion = $funcion_repo->findOneBy(array(
                    "anoEje" => $form->get("anoEje")->getData(),
                    "funcion" => $form->get("funcion")->getData()
                        ));
                if($funcion != null){
                    $status = "El funcion ya existe!!!";
                }else{
                    $funcion = new Funcion();
                    $funcion->setAnoEje($form->get("anoEje")->getData());
                    $funcion->setFuncion($form->get("funcion")->getData());
                    $funcion->setNombre($form->get("nombre")->getData());
                    $funcion->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($funcion);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El funcion se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("funcion_index");
        }
        return $this->render('@Planilla/funcion/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $funcion_repo = $em->getRepository("PlanillaBundle:Funcion");
        $funcion = $funcion_repo->find($id);
        
        $form = $this->createForm(FuncionType::class, $funcion);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $funcion->setAnoEje($form->get("anoEje")->getData());
                    $funcion->setFuncion($form->get("funcion")->getData());
                    $funcion->setNombre($form->get("nombre")->getData());
                    $funcion->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($funcion);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El funcion se ha editado correctamente";
                    } else {
                        $status = "Error al editar funcion!!";
                    }
 
            } else {
                $status = "El funcion no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("funcion_index");
        }
        return $this->render('@Planilla/funcion/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

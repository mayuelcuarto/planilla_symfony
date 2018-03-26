<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Meta;
use PlanillaBundle\Form\MetaType;

class MetaController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $meta_repo = $em->getRepository("PlanillaBundle:Meta");
        $metas = $meta_repo->findBy(array(), array('estado' => 'DESC','secFunc' => 'ASC'));

        return $this->render("@Planilla/meta/index.html.twig", array(
            "metas" => $metas
        ));
    }
    
    public function addAction(Request $request){
        $meta = new Meta();
        $form = $this->createForm(MetaType::class, $meta);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $meta_repo = $em->getRepository("PlanillaBundle:Meta");
                $meta = $meta_repo->findOneBy(array(
                    "programa" => $form->get("programa")->getData(),
                    "producto" => $form->get("producto")->getData(),
                    "actProy" => $form->get("actProy")->getData(),
                    "funcion" => $form->get("funcion")->getData(),
                    "divfunc" => $form->get("divfunc")->getData(),
                    "grpf" => $form->get("grpf")->getData(),
                    "ejecutora" => $form->get("ejecutora")->getData(),
                    "meta" => $form->get("meta")->getData(),
                    "finalidad" => $form->get("finalidad")->getData()
                        ));
                if($meta != null){
                    $status = "La meta ya existe!!!";
                }else{
                    $meta = new Meta();
                    $meta->setPrograma($form->get("programa")->getData());
                    $meta->setProducto($form->get("producto")->getData());
                    $meta->setActProy($form->get("actProy")->getData());
                    $meta->setFuncion($form->get("funcion")->getData());
                    $meta->setDivfunc($form->get("divfunc")->getData());
                    $meta->setGrpf($form->get("grpf")->getData());
                    $meta->setEjecutora($form->get("ejecutora")->getData());
                    $meta->setMeta($form->get("meta")->getData());
                    $meta->setFinalidad($form->get("finalidad")->getData());
                    $meta->setNombre($form->get("nombre")->getData());
                    $meta->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($meta);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La meta se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("meta_index");
        }
        return $this->render('@Planilla/meta/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $meta_repo = $em->getRepository("PlanillaBundle:Meta");
        $meta = $meta_repo->find($id);
        
        $form = $this->createForm(MetaType::class, $meta);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $meta->setPrograma($form->get("programa")->getData());
                    $meta->setProducto($form->get("producto")->getData());
                    $meta->setActProy($form->get("actProy")->getData());
                    $meta->setFuncion($form->get("funcion")->getData());
                    $meta->setDivfunc($form->get("divfunc")->getData());
                    $meta->setGrpf($form->get("grpf")->getData());
                    $meta->setEjecutora($form->get("ejecutora")->getData());
                    $meta->setMeta($form->get("meta")->getData());
                    $meta->setFinalidad($form->get("finalidad")->getData());
                    $meta->setNombre($form->get("nombre")->getData());
                    $meta->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($meta);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La meta se ha editado correctamente";
                    } else {
                        $status = "Error al editar meta!!";
                    }
 
            } else {
                $status = "La meta no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("meta_index");
        }
        return $this->render('@Planilla/meta/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

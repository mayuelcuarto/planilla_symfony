<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\CategoriaOcupacional;
use PlanillaBundle\Form\CategoriaOcupacionalType;
use PlanillaBundle\Form\CategoriaOcupacionalEditType;

class CategoriaOcupacionalController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $categoriaOcupacional_repo = $em->getRepository("PlanillaBundle:CategoriaOcupacional");
        $categoriaOcupacionals = $categoriaOcupacional_repo->findBy(array(), array('estado' => 'DESC','id' => 'ASC'));

        return $this->render("@Planilla/categoriaOcupacional/index.html.twig", array(
            "categoriaOcupacionals" => $categoriaOcupacionals
        ));
    }
    
    public function addAction(Request $request){
        $categoriaOcupacional = new CategoriaOcupacional();
        $form = $this->createForm(CategoriaOcupacionalType::class, $categoriaOcupacional);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $categoriaOcupacional_repo = $em->getRepository("PlanillaBundle:CategoriaOcupacional");
                $categoriaOcupacional = $categoriaOcupacional_repo->findOneBy(array(
                    "grupoOcupacional" => $form->get("grupoOcupacional")->getData(),
                    "categoriaOcupacional" => $form->get("categoriaOcupacional")->getData()
                        ));
                if($categoriaOcupacional != null){
                    $status = "La categoría ocupacional ya existe!!!";
                }else{
                    $categoriaOcupacional = new CategoriaOcupacional();
                    $categoriaOcupacional->setGrupoOcupacional($form->get("grupoOcupacional")->getData());
                    $categoriaOcupacional->setCategoriaOcupacional($form->get("categoriaOcupacional")->getData());
                    $categoriaOcupacional->setNombre($form->get("nombre")->getData());
                    $categoriaOcupacional->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($categoriaOcupacional);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La categoría ocupacional se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("categoriaOcupacional_index");
        }
        return $this->render('@Planilla/categoriaOcupacional/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $categoriaOcupacional_repo = $em->getRepository("PlanillaBundle:CategoriaOcupacional");
        $categoriaOcupacional = $categoriaOcupacional_repo->find($id);
        
        $form = $this->createForm(CategoriaOcupacionalEditType::class, $categoriaOcupacional);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $categoriaOcupacional->setGrupoOcupacional($form->get("grupoOcupacional")->getData());
                    $categoriaOcupacional->setCategoriaOcupacional($form->get("categoriaOcupacional")->getData());
                    $categoriaOcupacional->setNombre($form->get("nombre")->getData());
                    $categoriaOcupacional->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($categoriaOcupacional);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La categoría ocupacional se ha editado correctamente";
                    } else {
                        $status = "Error al editar categoría ocupacional!!";
                    }
 
            } else {
                $status = "La categoría ocupacional no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("categoriaOcupacional_index");
        }
        return $this->render('@Planilla/categoriaOcupacional/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

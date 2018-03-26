<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Grpf;
use PlanillaBundle\Form\GrpfType;

class GrpfController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $grpf_repo = $em->getRepository("PlanillaBundle:Grpf");
        $grpfs = $grpf_repo->findBy(array(), array('estado' => 'DESC','id' => 'ASC'));
        
        return $this->render("@Planilla/grpf/index.html.twig", array(
            "grpfs" => $grpfs
        ));
    }
    
    public function addAction(Request $request){
        $grpf = new Grpf();
        $form = $this->createForm(GrpfType::class, $grpf);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $grpf_repo = $em->getRepository("PlanillaBundle:Grpf");
                $grpf = $grpf_repo->findOneBy(array(
                    "anoEje" => $form->get("anoEje")->getData(),
                    "grpf" => $form->get("grpf")->getData()
                        ));
                if($grpf != null){
                    $status = "El grpf ya existe!!!";
                }else{
                    $grpf = new Grpf();
                    $grpf->setAnoEje($form->get("anoEje")->getData());
                    $grpf->setGrpf($form->get("grpf")->getData());
                    $grpf->setNombre($form->get("nombre")->getData());
                    $grpf->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($grpf);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El grpf se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grpf_index");
        }
        return $this->render('@Planilla/grpf/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $grpf_repo = $em->getRepository("PlanillaBundle:Grpf");
        $grpf = $grpf_repo->find($id);
        
        $form = $this->createForm(GrpfType::class, $grpf);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $grpf->setAnoEje($form->get("anoEje")->getData());
                    $grpf->setGrpf($form->get("grpf")->getData());
                    $grpf->setNombre($form->get("nombre")->getData());
                    $grpf->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($grpf);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El grpf se ha editado correctamente";
                    } else {
                        $status = "Error al editar grpf!!";
                    }
 
            } else {
                $status = "El grpf no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grpf_index");
        }
        return $this->render('@Planilla/grpf/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

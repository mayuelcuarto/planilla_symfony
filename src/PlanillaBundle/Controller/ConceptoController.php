<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Concepto;
use PlanillaBundle\Form\ConceptoType;
use PlanillaBundle\Form\ConceptoSearchType;

class ConceptoController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $concepto_repo = $em->getRepository("PlanillaBundle:Concepto");
        $conceptos = $concepto_repo->findBy(array('tipoConcepto' => 1), array('estado' => 'DESC','tipoConcepto' => 'ASC'));
        
        $concepto = new Concepto();
        $form = $this->createForm(ConceptoSearchType::class, $concepto);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoConcepto = $form->get("tipoConcepto")->getData();
                $conceptoCampo = $form->get("concepto")->getData();
                $abreviatura = $form->get("abreviatura")->getData();
                $mcppConcepto = $form->get("mcppConcepto")->getData();
                
                $em = $this->getDoctrine()->getManager();
                $concepto_repo = $em->getRepository("PlanillaBundle:Concepto")->createQueryBuilder('c')
                        ->where('c.tipoConcepto = :tipoConcepto')
                        ->andWhere('c.concepto LIKE :concepto')
                        ->andWhere('c.abreviatura LIKE :abreviatura')
                        ->andWhere('c.mcppConcepto LIKE :mcppConcepto')
                        ->setParameter('tipoConcepto', $tipoConcepto)
                        ->setParameter('concepto', '%'.$conceptoCampo.'%')
                        ->setParameter('abreviatura', '%'.$abreviatura.'%')
                        ->setParameter('mcppConcepto', '%'.$mcppConcepto.'%')
                        ->addOrderBy('c.estado', 'DESC')
                        ->addOrderBy('c.tipoConcepto', 'ASC')  
                        ->getQuery()
                        ->getResult();
                $conceptos = $concepto_repo;
                if(count($conceptos)==0){
                    $status = "La búsqueda no encontró coincidencias";
                }else{
                    $status = "Resultados de la búsqueda, listando ".count($conceptos)." concepto(s)";
                }
            } else {
            $status = "No te has registrado correctamente";
        }

            $this->session->getFlashBag()->add("status", $status);
            return $this->render("@Planilla/concepto/index.html.twig", array(
                "conceptos" => $conceptos,
                "form" => $form->createView()
            ));
        }
        
        return $this->render("@Planilla/concepto/index.html.twig", array(
            "conceptos" => $conceptos,
            "form" => $form->createView()
        ));
    }
    
    public function addAction(Request $request){
        $concepto = new Concepto();
        $form = $this->createForm(ConceptoType::class, $concepto);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $concepto_repo = $em->getRepository("PlanillaBundle:Concepto");
                $concepto = $concepto_repo->findOneBy(array("concepto" => $form->get("concepto")->getData()));
                if($concepto != null){
                    $status = "El concepto ya existe!!!";
                }else{
                    $concepto = new Concepto();
                    $concepto->setTipoConcepto($form->get("tipoConcepto")->getData());
                    $concepto->setConcepto($form->get("concepto")->getData());
                    $concepto->setMcppConcepto($form->get("mcppConcepto")->getData());
                    $concepto->setAbreviatura($form->get("abreviatura")->getData());
                    $concepto->setEstado($form->get("estado")->getData());
                    $concepto->setEsActivo($form->get("esActivo")->getData());
                    $concepto->setEsPension($form->get("esPension")->getData());
                    $concepto->setEsPatronal($form->get("esPatronal")->getData());
                    $concepto->setEsAsegurada($form->get("esAsegurada")->getData());
                    $concepto->setEsAfp($form->get("esAfp")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($concepto);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El concepto se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("concepto_index");
        }
        return $this->render('@Planilla/concepto/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $concepto_repo = $em->getRepository("PlanillaBundle:Concepto");
        $concepto = $concepto_repo->find($id);
        
        $form = $this->createForm(ConceptoType::class, $concepto);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $concepto->setTipoConcepto($form->get("tipoConcepto")->getData());
                    $concepto->setConcepto($form->get("concepto")->getData());
                    $concepto->setMcppConcepto($form->get("mcppConcepto")->getData());
                    $concepto->setAbreviatura($form->get("abreviatura")->getData());
                    $concepto->setEstado($form->get("estado")->getData());
                    $concepto->setEsActivo($form->get("esActivo")->getData());
                    $concepto->setEsPension($form->get("esPension")->getData());
                    $concepto->setEsPatronal($form->get("esPatronal")->getData());
                    $concepto->setEsAsegurada($form->get("esAsegurada")->getData());
                    $concepto->setEsAfp($form->get("esAfp")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($concepto);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El concepto se ha editado correctamente";
                    } else {
                        $status = "Error al editar concepto!!";
                    }
 
            } else {
                $status = "El concepto no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("concepto_index");
        }
        return $this->render('@Planilla/concepto/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

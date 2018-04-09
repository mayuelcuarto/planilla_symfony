<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Planilla;
use PlanillaBundle\Form\PlanillaType;
use PlanillaBundle\Form\PlanillaEditType;
use PlanillaBundle\Form\PlanillaSearchType;
use PDO;

class PlanillaController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $anoEje = 2017;
        //$anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(array("mesEje" => 10));
        //$mesEje = $mes_repo->findOneBy(array("mesEje" => date("m")));
        
        $dql = $em->createQuery("SELECT pl FROM PlanillaBundle:Planilla pl 
                                        INNER JOIN pl.plazaHistorial ph
                                        INNER JOIN ph.plaza pla
                                        WHERE  
                                        pla.tipoPlanilla = :tipoPlanilla AND 
                                        pl.anoEje = :anoEje AND 
                                        pl.mesEje = :mesEje 
                                        ORDER BY pl.id")
                    ->setParameter('tipoPlanilla', 1)
                    ->setParameter('anoEje', $anoEje)
                    ->setParameter('mesEje', $mesEje);
        $planillas = $dql->getResult();
        
        $planilla = new Planilla();
        $form = $this->createForm(PlanillaSearchType::class, $planilla);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $var_personal = $form->get("personal")->getData();
                
                if($var_personal!=null){
                    $dql = $em->createQuery("SELECT pl FROM PlanillaBundle:Planilla pl 
                                        INNER JOIN pl.plazaHistorial ph
                                        INNER JOIN ph.codPersonal pe 
                                        INNER JOIN ph.plaza pla
                                        WHERE 
                                        ((pe.apellidoPaterno LIKE :var_personal) 
                                        OR (pe.apellidoMaterno LIKE :var_personal) 
                                        OR (pe.nombre LIKE :var_personal)) AND
                                        pla.tipoPlanilla = :tipoPlanilla AND 
                                        pl.anoEje = :anoEje AND
                                        pl.mesEje = :mesEje
                                        ORDER BY pl.id")
                    ->setParameter('tipoPlanilla', $tipoPlanilla)
                    ->setParameter('anoEje', $anoEje)
                    ->setParameter('mesEje', $mesEje)
                    ->setParameter('var_personal', "%".$var_personal."%");
                    $planillas = $dql->getResult();
                }else{
                    $dql = $em->createQuery("SELECT pl FROM PlanillaBundle:Planilla pl 
                                        INNER JOIN pl.plazaHistorial ph
                                        INNER JOIN ph.plaza pla
                                        WHERE  
                                        pla.tipoPlanilla = :tipoPlanilla AND 
                                        pl.anoEje = :anoEje AND 
                                        pl.mesEje = :mesEje 
                                        ORDER BY pl.id")
                    ->setParameter('tipoPlanilla', $tipoPlanilla)
                    ->setParameter('anoEje', $anoEje)
                    ->setParameter('mesEje', $mesEje);
                    $planillas = $dql->getResult();
                }
                if(count($planillas)==0){
                    $status = "La búsqueda no encontró coincidencias";
                }else{
                    $status = "Resultados de la búsqueda, listando ".count($planillas)." planilla(s)";
                }
            } else {
            $status = "No te has registrado correctamente";
        }

            $this->session->getFlashBag()->add("status", $status);
            return $this->render("@Planilla/planilla/index.html.twig", array(
                "planillas" => $planillas,
                "form" => $form->createView(),
                "tipoPlanilla" => $tipoPlanilla->getId()
            ));
        }
        
        return $this->render("@Planilla/planilla/index.html.twig", array(
            "planillas" => $planillas,
            "form" => $form->createView(),
            "tipoPlanilla" => 1
        ));
    }
    
    public function addAction(Request $request, $tipoPlanilla){
        $planilla = new Planilla();
        $em = $this->getDoctrine()->getManager();
        $anoEje = 2017;
        //$anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(array("mesEje" => 10));
        //$mesEje = $mes_repo->findOneBy(array("mesEje" => date("m")));

        $tipoPlanilla_repo = $em->getRepository("PlanillaBundle:TipoPlanilla");
        $tipoPlanilla2 = $tipoPlanilla_repo->findOneBy(["id" => $tipoPlanilla]);
        
        $dql = $em->createQuery("SELECT ph FROM PlanillaBundle:PlazaHistorial ph 
                                        INNER JOIN ph.plaza pl 
                                        INNER JOIN ph.codPersonal pe
                                        WHERE 
                                        ph.estado = 1 AND 
                                        pl.tipoPlanilla = :tipoPlanilla  
                                        ORDER BY pe.apellidoPaterno ")
                    ->setParameter('tipoPlanilla', $tipoPlanilla);
        $plazas = $dql->getResult();
        
        $form = $this->createForm(PlanillaType::class, $planilla, array('plazas' => $plazas));
        
        
        
        
        $form->get("anoEje")->setData($anoEje);
        $form->get("mesEje")->setData($mesEje);
        $form->get("tipoPlanilla")->setData($tipoPlanilla2);        
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
                $planilla = $planilla_repo->findOneBy(array(
                    "numPlanilla" => $form->get("numPlanilla")->getData(),
                    "tipoPlanilla" => $form->get("tipoPlanilla")->getData()
                        ));
                if($planilla != null){
                    $status = "La planilla ya existe!!!";
                }else{
                    $planilla = new Planilla();
                    $planilla->setTipoPlanilla($form->get("tipoPlanilla")->getData());
                    $planilla->setNumPlanilla($form->get("numPlanilla")->getData());
                    $planilla->setSecFunc($form->get("secFunc")->getData());
                    $planilla->setEspecifica($form->get("especifica")->getData());
                    $planilla->setCategoria($form->get("categoria")->getData());
                    $planilla->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($planilla);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La planilla se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planilla_index");
        }
        return $this->render('@Planilla/planilla/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        //$planilla = new Planilla();
        $em = $this->getDoctrine()->getManager();
        $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
        $planilla = $planilla_repo->find($id);
        
        $tipoPlanilla = $planilla->getPlazaHistorial()->getPlaza()->getTipoPlanilla();
        $form = $this->createForm(PlanillaEditType::class, $planilla);
        $form->get("tipoPlanilla")->setData($tipoPlanilla);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $planilla->setTipoPlanilla($form->get("tipoPlanilla")->getData());
                    $planilla->setNumPlanilla($form->get("numPlanilla")->getData());
                    $planilla->setSecFunc($form->get("secFunc")->getData());
                    $planilla->setEspecifica($form->get("especifica")->getData());
                    $planilla->setCategoria($form->get("categoria")->getData());
                    $planilla->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($planilla);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La planilla se ha editado correctamente";
                    } else {
                        $status = "Error al editar planilla!!";
                    }
 
            } else {
                $status = "La planilla no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("planilla_index");
        }
        return $this->render('@Planilla/planilla/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Plaza;
use PlanillaBundle\Form\PlazaType;
use PlanillaBundle\Form\PlazaEditType;
use PlanillaBundle\Form\PlazaSearchType;
use PDO;

class PlazaController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $plaza_repo = $em->getRepository("PlanillaBundle:Plaza");
        $plazas = $plaza_repo->findBy(array("tipoPlanilla" => 1), array('estado' => 'DESC','tipoPlanilla' => 'ASC'));
        
        $plaza = new Plaza();
        $form = $this->createForm(PlazaSearchType::class, $plaza);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoPlanilla = $form->get("tipoPlanilla")->getData();
                $var_personal = $form->get("personal")->getData();
                
                if($var_personal!=null){
                    $dql = $em->createQuery("SELECT pl FROM PlanillaBundle:Plaza pl 
                                        INNER JOIN pl.plazaHistorial ph
                                        INNER JOIN ph.codPersonal pe 
                                        WHERE  
                                        ((pe.apellidoPaterno LIKE :var_personal) 
                                        OR (pe.apellidoMaterno LIKE :var_personal) 
                                        OR (pe.nombre LIKE :var_personal))
                                        AND pl.tipoPlanilla = :tipoPlanilla 
                                        ORDER BY ph.estado DESC")
                    ->setParameter('tipoPlanilla', $tipoPlanilla)
                    ->setParameter('var_personal', "%".$var_personal."%");
                    $plazas = $dql->getResult();
                }else{
                    $plazas = $plaza_repo->findBy(array("tipoPlanilla" => $tipoPlanilla), array('estado' => 'DESC','tipoPlanilla' => 'ASC'));
                }
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
                "form" => $form->createView(),
                "tipoPlanilla" => $tipoPlanilla->getId()
            ));
        }
        
        return $this->render("@Planilla/plaza/index.html.twig", array(
            "plazas" => $plazas,
            "form" => $form->createView(),
            "tipoPlanilla" => 1
        ));
    }
    
    public function addAction(Request $request, $tipoPlanilla){
        $plaza = new Plaza();
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()
                    ->prepare("SELECT SugerirPlaza(:tipoPlanilla)");
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla);
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $numPlaza = $fila[0];
        }
        
        $form = $this->createForm(PlazaType::class, $plaza);
        $tipoPlanilla_repo = $em->getRepository("PlanillaBundle:TipoPlanilla");
        $tipoPlanilla2 = $tipoPlanilla_repo->findOneBy(array(
                    "id" => $tipoPlanilla
                        ));
        
        $form->get("tipoPlanilla")->setData($tipoPlanilla2);
        $form->get("numPlaza")->setData($numPlaza);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
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
        
        $form = $this->createForm(PlazaEditType::class, $plaza);
        
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

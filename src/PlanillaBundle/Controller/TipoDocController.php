<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\TipoDoc;
use PlanillaBundle\Form\TipoDocType;
use PlanillaBundle\Form\TipoDocEditType;
use PDO;

class TipoDocController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $tipoDoc_repo = $em->getRepository("PlanillaBundle:TipoDoc");
        $tipoDocs = $tipoDoc_repo->findBy(array(), array('estado' => 'DESC','id' => 'ASC'));
        
        return $this->render("@Planilla/tipoDoc/index.html.twig", array(
            "tipoDocs" => $tipoDocs
        ));
    }
    
    public function addAction(Request $request){
        $tipoDoc = new TipoDoc();
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()
                    ->prepare("SELECT SugerirTipoDoc()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id = $fila[0];
        }
        $form = $this->createForm(TipoDocType::class, $tipoDoc);
        
        $form->get("id")->setData($id);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $tipoDoc_repo = $em->getRepository("PlanillaBundle:TipoDoc");
                $tipoDoc = $tipoDoc_repo->findOneBy(array(
                    "nombre" => $form->get("nombre")->getData()
                        ));
                if($tipoDoc != null){
                    $status = "El tipo de documento ya existe!!!";
                }else{
                    $tipoDoc = new TipoDoc();
                    $tipoDoc->setNombre($form->get("nombre")->getData());
                    $tipoDoc->setEstado($form->get("estado")->getData());
                    
                    $id = $form->get("id")->getData();
                    $nombre = $tipoDoc->getNombre();
                    $estado = $tipoDoc->getEstado();

                    $sth = $em
                            ->getConnection()
                            ->prepare("CALL AgregarTipoDoc(:id, :nombre, :estado)");
                    
                    $sth->bindValue(':id', $id);
                    $sth->bindValue(':nombre', $nombre);
                    $sth->bindValue(':estado', $estado);
                    $sth->execute();
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El tipo de documento se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("tipoDoc_index");
        }
        return $this->render('@Planilla/tipoDoc/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $tipoDoc_repo = $em->getRepository("PlanillaBundle:TipoDoc");
        $tipoDoc = $tipoDoc_repo->find($id);
        
        $form = $this->createForm(TipoDocEditType::class, $tipoDoc);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $tipoDoc->setNombre($form->get("nombre")->getData());
                    $tipoDoc->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tipoDoc);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El tipo de documento se ha editado correctamente";
                    } else {
                        $status = "Error al editar tipo de documento!!";
                    }
 
            } else {
                $status = "El tipo de documento no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("tipoDoc_index");
        }
        return $this->render('@Planilla/tipoDoc/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

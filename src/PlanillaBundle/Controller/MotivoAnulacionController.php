<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\MotivoAnulacion;
use PlanillaBundle\Form\MotivoAnulacionType;
use PlanillaBundle\Form\MotivoAnulacionEditType;
use PDO;

class MotivoAnulacionController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $motivoAnulacion_repo = $em->getRepository("PlanillaBundle:MotivoAnulacion");
        $motivoAnulacions = $motivoAnulacion_repo->findBy(array(), array('estado' => 'DESC','id' => 'ASC'));
        
        return $this->render("@Planilla/motivoAnulacion/index.html.twig", array(
            "motivoAnulacions" => $motivoAnulacions
        ));
    }
    
    public function addAction(Request $request){
        $motivoAnulacion = new MotivoAnulacion();
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()
                    ->prepare("SELECT SugerirMotivoAnulacion()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id = $fila[0];
        }
        $form = $this->createForm(MotivoAnulacionType::class, $motivoAnulacion);
        
        $form->get("id")->setData($id);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $motivoAnulacion_repo = $em->getRepository("PlanillaBundle:MotivoAnulacion");
                $motivoAnulacion = $motivoAnulacion_repo->findOneBy(array(
                    "nombre" => $form->get("nombre")->getData()
                        ));
                if($motivoAnulacion != null){
                    $status = "El motivo de anulación ya existe!!!";
                }else{
                    $motivoAnulacion = new MotivoAnulacion();
                    $motivoAnulacion->setNombre($form->get("nombre")->getData());
                    $motivoAnulacion->setEstado($form->get("estado")->getData());
                    
                    $id = $form->get("id")->getData();
                    $nombre = $motivoAnulacion->getNombre();
                    $estado = $motivoAnulacion->getEstado();

                    $sth = $em
                            ->getConnection()
                            ->prepare("CALL AgregarMotivoAnulacion(:id, :nombre, :estado)");
                    
                    $sth->bindValue(':id', $id);
                    $sth->bindValue(':nombre', $nombre);
                    $sth->bindValue(':estado', $estado);
                    $sth->execute();
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El motivo de anulación se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("motivoAnulacion_index");
        }
        return $this->render('@Planilla/motivoAnulacion/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $motivoAnulacion_repo = $em->getRepository("PlanillaBundle:MotivoAnulacion");
        $motivoAnulacion = $motivoAnulacion_repo->find($id);
        
        $form = $this->createForm(MotivoAnulacionEditType::class, $motivoAnulacion);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $motivoAnulacion->setNombre($form->get("nombre")->getData());
                    $motivoAnulacion->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($motivoAnulacion);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El motivo de anulación se ha editado correctamente";
                    } else {
                        $status = "Error al editar motivo de anulación!!";
                    }
 
            } else {
                $status = "El motivo de anulación no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("motivoAnulacion_index");
        }
        return $this->render('@Planilla/motivoAnulacion/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

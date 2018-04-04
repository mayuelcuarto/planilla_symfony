<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\GrupoOcupacional;
use PlanillaBundle\Form\GrupoOcupacionalType;
use PlanillaBundle\Form\GrupoOcupacionalEditType;
use PDO;

class GrupoOcupacionalController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $grupoOcupacional_repo = $em->getRepository("PlanillaBundle:GrupoOcupacional");
        $grupoOcupacionals = $grupoOcupacional_repo->findBy(array(), array('estado' => 'DESC','grupoOcupacional' => 'ASC'));
        
        return $this->render("@Planilla/grupoOcupacional/index.html.twig", array(
            "grupoOcupacionals" => $grupoOcupacionals
        ));
    }
    
    public function addAction(Request $request){
        $grupoOcupacional = new GrupoOcupacional();
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()
                    ->prepare("SELECT SugerirGrupoOcupacional()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id = $fila[0];
        }
        $form = $this->createForm(GrupoOcupacionalType::class, $grupoOcupacional);
        
        $form->get("id")->setData($id);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $grupoOcupacional_repo = $em->getRepository("PlanillaBundle:GrupoOcupacional");
                $grupoOcupacional = $grupoOcupacional_repo->findOneBy(array(
                    "nombre" => $form->get("nombre")->getData()
                        ));
                if($grupoOcupacional != null){
                    $status = "El grupo ocupacional ya existe!!!";
                }else{
                    $grupoOcupacional = new GrupoOcupacional();
                    $grupoOcupacional->setNombre($form->get("nombre")->getData());
                    $grupoOcupacional->setEstado($form->get("estado")->getData());
                    
                    $id = $form->get("id")->getData();
                    $nombre = $grupoOcupacional->getNombre();
                    $estado = $grupoOcupacional->getEstado();

                    $sth = $em
                            ->getConnection()
                            ->prepare("CALL AgregarGrupoOcupacional(:id, :nombre, :estado)");
                    
                    $sth->bindValue(':id', $id);
                    $sth->bindValue(':nombre', $nombre);
                    $sth->bindValue(':estado', $estado);
                    $sth->execute();
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El grupo ocupacional se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    } 
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grupoOcupacional_index");
        }
        return $this->render('@Planilla/grupoOcupacional/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $grupoOcupacional_repo = $em->getRepository("PlanillaBundle:GrupoOcupacional");
        $grupoOcupacional = $grupoOcupacional_repo->find($id);
        
        $form = $this->createForm(GrupoOcupacionalEditType::class, $grupoOcupacional);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $grupoOcupacional->setNombre($form->get("nombre")->getData());
                    $grupoOcupacional->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($grupoOcupacional);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El grupo ocupacional se ha editado correctamente";
                    } else {
                        $status = "Error al editar grupo ocupacional!!";
                    }
 
            } else {
                $status = "El grupo ocupacional no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("grupoOcupacional_index");
        }
        return $this->render('@Planilla/grupoOcupacional/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

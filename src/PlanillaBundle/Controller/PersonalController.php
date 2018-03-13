<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Personal;
use PlanillaBundle\Form\PersonalType;
use PlanillaBundle\Form\PersonalSearchType;

class PersonalController extends Controller
{
    private $session;

    public function __construct() {
        $this->session = new Session();
    }
    
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $personal_repo = $em->getRepository("PlanillaBundle:Personal");
        $personales = $personal_repo->findBy(array(), array('estado' => 'DESC','apellidoPaterno' => 'ASC'));
        
        $personal = new Personal();
        $form = $this->createForm(PersonalSearchType::class, $personal);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $apellidoPaterno = $form->get("apellidoPaterno")->getData();
                $apellidoMaterno = $form->get("apellidoMaterno")->getData();
                $nombre = $form->get("nombre")->getData();
                
                $em = $this->getDoctrine()->getManager();
                $personal_repo = $em->getRepository("PlanillaBundle:Personal")->createQueryBuilder('p')
                        ->where('p.apellidoPaterno LIKE :apellidoPaterno')
                        ->andWhere('p.apellidoMaterno LIKE :apellidoMaterno')
                        ->andWhere('p.nombre LIKE :nombre')
                        ->setParameter('apellidoPaterno', '%'.$apellidoPaterno.'%')
                        ->setParameter('apellidoMaterno', '%'.$apellidoMaterno.'%')
                        ->setParameter('nombre', '%'.$nombre.'%')
                        ->addOrderBy('p.estado', 'DESC')
                        ->addOrderBy('p.apellidoPaterno', 'ASC')  
                        ->getQuery()
                        ->getResult();
                $personales = $personal_repo;
                if(count($personales)==0){
                    $status = "La búsqueda no encontró coincidencias";
                }else{
                    $status = "Resultados de la búsqueda, listando ".count($personales)." persona(s)";
                }
            } else {
            $status = "No te has registrado correctamente";
        }

            $this->session->getFlashBag()->add("status", $status);
            return $this->render("@Planilla/personal/index.html.twig", array(
                "personales" => $personales,
                "form" => $form->createView()
            ));
        }
        
        return $this->render("@Planilla/personal/index.html.twig", array(
            "personales" => $personales,
            "form" => $form->createView()
        ));
    }
    
    public function addAction(Request $request){
        $personal = new Personal();
        $form = $this->createForm(PersonalType::class, $personal);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $personal_repo = $em->getRepository("PlanillaBundle:Personal");
                $personal = $personal_repo->findOneBy(array("numeroDocumento" => $form->get("numeroDocumento")->getData()));
                if(count($personal)==0){
                    $personal = new Personal();
                    $personal->setApellidoPaterno($form->get("apellidoPaterno")->getData());
                    $personal->setApellidoMaterno($form->get("apellidoMaterno")->getData());
                    $personal->setNombre($form->get("nombre")->getData());
                    $personal->setAnexo($form->get("anexo")->getData());
                    $personal->setFechaNacimiento($form->get("fechaNacimiento")->getData());
                    $personal->setTipoDoc($form->get("tipoDoc")->getData());
                    $personal->setNumeroDocumento($form->get("numeroDocumento")->getData());
                    $personal->setSexo($form->get("sexo")->getData());
                    $personal->setCuspp($form->get("cuspp")->getData());
                    $personal->setNumAutogenerado($form->get("numAutogenerado")->getData());
                    $personal->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($personal);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "Personal creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }else{
                    $status = "El personal ya existe!!!";
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("personal_index");
        }
        return $this->render('@Planilla/personal/add.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
    
    public function editAction(Request $request, $codPersonal){
        $em = $this->getDoctrine()->getManager();
        $personal_repo = $em->getRepository("PlanillaBundle:Personal");
        $personal = $personal_repo->find($codPersonal);
        
        $form = $this->createForm(PersonalType::class, $personal);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                    $personal->setApellidoPaterno($form->get("apellidoPaterno")->getData());
                    $personal->setApellidoMaterno($form->get("apellidoMaterno")->getData());
                    $personal->setNombre($form->get("nombre")->getData());
                    $personal->setAnexo($form->get("anexo")->getData());
                    $personal->setFechaNacimiento($form->get("fechaNacimiento")->getData());
                    $personal->setTipoDoc($form->get("tipoDoc")->getData());
                    $personal->setNumeroDocumento($form->get("numeroDocumento")->getData());
                    $personal->setSexo($form->get("sexo")->getData());
                    $personal->setCuspp($form->get("cuspp")->getData());
                    $personal->setNumAutogenerado($form->get("numAutogenerado")->getData());
                    $personal->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($personal);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "Personal editado correctamente";
                    } else {
                        $status = "Error al editar personal!!";
                    }
 
            } else {
                $status = "Personal no editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("personal_index");
        }
        return $this->render('@Planilla/personal/edit.html.twig',
                array(
                    "form" => $form->createView()
                )
                );
    }
}

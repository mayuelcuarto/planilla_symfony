<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Meta;
use PlanillaBundle\Form\MetaType;
use PlanillaBundle\Form\MetaEditType;

class MetaController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $metas = $em->getRepository("PlanillaBundle:Meta")->findAll();
        return $this->render("@Planilla/meta/index.html.twig", ["metas" => $metas]);
    }

    public function addAction(Request $request) {
        $meta = new Meta();
        $form = $this->createForm(MetaType::class, $meta);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $meta_repo = $em->getRepository("PlanillaBundle:Meta");
                $meta = $meta_repo->findOneBy([
                    "programa" => $form->get("programa")->getData(),
                    "producto" => $form->get("producto")->getData(),
                    "actProy" => $form->get("actProy")->getData(),
                    "funcion" => $form->get("funcion")->getData(),
                    "divfunc" => $form->get("divfunc")->getData(),
                    "grpf" => $form->get("grpf")->getData(),
                    "ejecutora" => $form->get("ejecutora")->getData(),
                    "meta" => $form->get("meta")->getData(),
                    "finalidad" => $form->get("finalidad")->getData()
                ]);
                if ($meta != null) {
                    $status = "La meta ya existe!!!";
                } else {
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
                        $status = "Error al agregar meta!!";
                    }
                }
            } else {
                $status = "La meta no se agregó, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("meta_index");
        }
        return $this->render('@Planilla/meta/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        //$meta = new Meta();
        $meta_repo = $em->getRepository("PlanillaBundle:Meta");
        $meta = $meta_repo->find($id);
        //Obteniendo datos de programas
        $programa_repo = $em->getRepository("PlanillaBundle:Programa");
        $programa = $programa_repo->findByIdEstado($meta->getPrograma(),1);
        //Obteniendo datos de productos
        $producto_repo = $em->getRepository("PlanillaBundle:Producto");
        $producto = $producto_repo->findByIdEstado($meta->getProducto(),1);
        //Obteniendo datos de actividades
        $actividad_repo = $em->getRepository("PlanillaBundle:ActProy");
        $actividad = $actividad_repo->findByIdEstado($meta->getActProy(),1);
        //Obteniendo datos de funciones
        $funcion_repo = $em->getRepository("PlanillaBundle:Funcion");
        $funcion = $funcion_repo->findByIdEstado($meta->getFuncion(),1);
        //Obteniendo datos de divisiones funcionales
        $divfunc_repo = $em->getRepository("PlanillaBundle:Divfunc");
        $divfunc = $divfunc_repo->findByIdEstado($meta->getDivfunc(),1);
        //Obteniendo datos de grupos funcionales
        $grpf_repo = $em->getRepository("PlanillaBundle:Grpf");
        $grpf = $grpf_repo->findByIdEstado($meta->getGrpf(),1);
        //Obteniendo datos de ejecutoras
        $ejecutora_repo = $em->getRepository("PlanillaBundle:Ejecutora");
        $ejecutora = $ejecutora_repo->findByIdEstado($meta->getEjecutora(),1);
        
        $form = $this->createForm(MetaEditType::class, $meta,[
            "programa" => $programa,
            "programaSeleccion" => $meta->getPrograma(),
            "producto" => $producto,
            "productoSeleccion" => $meta->getProducto(),
            "actividad" => $actividad,
            "actividadSeleccion" => $meta->getActProy(),
            "funcion" => $funcion,
            "funcionSeleccion" => $meta->getFuncion(),
            "divfunc" => $divfunc,
            "divfuncSeleccion" => $meta->getDivfunc(),
            "grpf" => $grpf,
            "grpfSeleccion" => $meta->getGrpf(),
            "ejecutora" => $ejecutora,
            "ejecutoraSeleccion" => $meta->getEjecutora()
        ]);
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
        return $this->render('@Planilla/meta/edit.html.twig', ["form" => $form->createView()]);
    }

}

<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Producto;
use PlanillaBundle\Form\ProductoType;

class ProductoController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $producto_repo = $em->getRepository("PlanillaBundle:Producto");
        $productos = $producto_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/producto/index.html.twig", ["productos" => $productos]);
    }

    public function addAction(Request $request) {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $producto_repo = $em->getRepository("PlanillaBundle:Producto");
                $producto = $producto_repo->findOneBy([
                    "anoEje" => $form->get("anoEje")->getData(),
                    "producto" => $form->get("producto")->getData()
                ]);
                if ($producto != null) {
                    $status = "El producto ya existe!!!";
                } else {
                    $producto = new Producto();
                    $producto->setAnoEje($form->get("anoEje")->getData());
                    $producto->setProducto($form->get("producto")->getData());
                    $producto->setNombre($form->get("nombre")->getData());
                    $producto->setEstado($form->get("estado")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($producto);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El producto se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("producto_index");
        }
        return $this->render('@Planilla/producto/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $producto_repo = $em->getRepository("PlanillaBundle:Producto");
        $producto = $producto_repo->find($id);

        $form = $this->createForm(ProductoType::class, $producto);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $producto->setAnoEje($form->get("anoEje")->getData());
                $producto->setProducto($form->get("producto")->getData());
                $producto->setNombre($form->get("nombre")->getData());
                $producto->setEstado($form->get("estado")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($producto);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El producto se ha editado correctamente";
                } else {
                    $status = "Error al editar producto!!";
                }
            } else {
                $status = "El producto no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("producto_index");
        }
        return $this->render('@Planilla/producto/edit.html.twig', ["form" => $form->createView()]);
    }

}

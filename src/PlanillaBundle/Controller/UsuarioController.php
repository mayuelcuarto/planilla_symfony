<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Usuario;
use PlanillaBundle\Form\UsuarioType;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class UsuarioController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function loginAction() {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($error) {
            $error_message = $error->getMessage();
        } else {
            $error_message = null;
        }
        $translator = new Translator('es_ES');
        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', [
            'Bad credentials.' => 'Credenciales incorrectas.',
            'User account is locked.' => 'La cuenta de usuario se encuentra bloqueada.'
                ], 'es_ES');
        $translated = $translator->trans($error_message);
        
        return $this->render('@Planilla/usuario/login.html.twig', [
                    "error" => $translated,
                    "last_username" => $lastUsername,
        ]);
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $usuario_repo = $em->getRepository("PlanillaBundle:Usuario");
        $usuarios = $usuario_repo->findAll();

        return $this->render("@Planilla/usuario/index.html.twig", ["usuarios" => $usuarios]);
    }

    public function addAction(Request $request) {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $usuario_repo = $em->getRepository("PlanillaBundle:Usuario");
                $usuario = $usuario_repo->findOneBy(["nick" => $form->get("nick")->getData()]);
                if ($usuario != null) {
                    $status = "El usuario ya existe!!!";
                } else {
                    $usuario = new Usuario();
                    $usuario->setApellidos($form->get("apellidos")->getData());
                    $usuario->setNombres($form->get("nombres")->getData());
                    $usuario->setDni($form->get("dni")->getData());
                    $usuario->setCargo($form->get("cargo")->getData());
                    $usuario->setNick($form->get("nick")->getData());

                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($usuario);
                    $password = $encoder->encodePassword($form->get("password")->getData(), $usuario->getSalt());

                    $usuario->setPassword($password);
                    $usuario->setClaveapi($password);
                    $usuario->setRole($form->get("role")->getData());
                    $usuario->setEstado($form->get("estado")->getData());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($usuario);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El usuario se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("usuario_index");
        }
        return $this->render('@Planilla/usuario/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $usuario_repo = $em->getRepository("PlanillaBundle:Usuario");
        $usuario = $usuario_repo->find($id);
        $pass = $usuario->getPassword();

        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $usuario->setApellidos($form->get("apellidos")->getData());
                $usuario->setNombres($form->get("nombres")->getData());
                $usuario->setDni($form->get("dni")->getData());
                $usuario->setCargo($form->get("cargo")->getData());
                $usuario->setNick($form->get("nick")->getData());
                $passForm = $form->get("password")->getData();
                if ($passForm != null and $passForm != "") {
                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($usuario);
                    $password = $encoder->encodePassword($form->get("password")->getData(), $usuario->getSalt());
                    $usuario->setPassword($password);
                    $usuario->setClaveapi($password);
                } else {
                    var_dump($pass);
                    $usuario->setPassword($pass);
                    $usuario->setClaveapi($pass);
                }

                $usuario->setRole($form->get("role")->getData());
                $usuario->setEstado($form->get("estado")->getData());

                $em->persist($usuario);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "El usuario se ha editado correctamente!!";
                } else {
                    $status = "Error al editar usuario!!";
                }
            } else {
                $status = "El usuario no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("usuario_index");
        }

        return $this->render("@Planilla/usuario/edit.html.twig", ["form" => $form->createView()]);
    }

    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $usuario_repo = $em->getRepository("PlanillaBundle:Usuario");
        $usuario = $usuario_repo->find($id);
        $em->remove($usuario);
        $em->flush();
        $status = "El usuario ha sido eliminado!!";
        $this->session->getFlashBag()->add("status", $status);
        return $this->redirectToRoute("usuario_index");
    }

}

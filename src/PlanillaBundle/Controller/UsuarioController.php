<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PlanillaBundle\Entity\Usuario;
use PlanillaBundle\Form\UsuarioType;

class UsuarioController extends Controller
{
    public function loginAction(Request $request){
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $usuario_repo = $em->getRepository("PlanillaBundle:Usuario");
                $usuario = $usuario_repo->findOneBy(array("nick" => $form->get("nick")->getData()));
                if(count($usuario)==0){
                    $usuario = new Usuario();
                    $usuario->setDni($form->get("dni")->getData());
                    $usuario->setApellidos($form->get("apellidos")->getData());
                    $usuario->setNombres($form->get("nombres")->getData());
                    $usuario->setNick($form->get("nick")->getData());

                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($usuario);
                    $password = $encoder->encodePassword($form->get("password")->getData(), $usuario->getSalt());

                    $usuario->setPassword($password);
                    $usuario->setRole("ROLE_USER");
                    $usuario->setImage(null);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($usuario);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "El usuario se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }else{
                    $status = "El usuario ya existe!!!";
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
        }
        
        return $this->render('@Planilla/usuario/login.html.twig',
                array(
                    "error" => $error,
                    "last_username" => $lastUsername,
                    "form" => $form->createView()
                )
                );
    }
}

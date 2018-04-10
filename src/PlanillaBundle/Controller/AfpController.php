<?php

namespace PlanillaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use PlanillaBundle\Entity\Afp;
use PlanillaBundle\Form\AfpType;
use PlanillaBundle\Form\AfpEditType;
use PDO;

class AfpController extends Controller {

    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $afp_repo = $em->getRepository("PlanillaBundle:Afp");
        $afps = $afp_repo->findBy([], ['estado' => 'DESC', 'id' => 'ASC']);

        return $this->render("@Planilla/afp/index.html.twig", ["afps" => $afps]);
    }

    public function addAction(Request $request) {
        $afp = new Afp();
        $em = $this->getDoctrine()->getManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirAfp()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $id = $fila[0];
        }

        $form = $this->createForm(AfpType::class, $afp);
        $form->get("id")->setData($id);
        $form->get("estado")->setData(true);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $afp_repo = $em->getRepository("PlanillaBundle:Afp");
                $afp = $afp_repo->findOneBy(["id" => $form->get("id")->getData()]);
                if ($afp != null) {
                    $status = "La afp ya existe!!!";
                } else {
                    $afp = new Afp();
                    $afp->setNombre($form->get("nombre")->getData());
                    $afp->setEstado($form->get("estado")->getData());
                    $afp->setRegimenPensionario($form->get("regimenPensionario")->getData());
                    $afp->setSnp($form->get("snp")->getData());
                    $afp->setJubilacion($form->get("jubilacion")->getData());
                    $afp->setSeguros($form->get("seguros")->getData());
                    $afp->setRa($form->get("ra")->getData());
                    $afp->setPension($form->get("pension")->getData());
                    $afp->setRaMixta($form->get("raMixta")->getData());

                    $id = $form->get("id")->getData();
                    $nombre = $afp->getNombre();
                    $regimenPensionario = $afp->getRegimenPensionario()->getId();
                    $estado = $afp->getEstado();
                    $snp = $afp->getSnp();
                    $jubilacion = $afp->getJubilacion();
                    $seguros = $afp->getSeguros();
                    $ra = $afp->getRa();
                    $pension = $afp->getPension();
                    $raMixta = $afp->getRaMixta();

                    $sth = $em->getConnection()->prepare("CALL AgregarAFP(:id, :nombre, :regimenPensionario, :estado, :snp, :jubilacion, :seguros, :ra, :pension, :raMixta)");

                    $sth->bindValue(':id', $id);
                    $sth->bindValue(':nombre', $nombre);
                    $sth->bindValue(':regimenPensionario', $regimenPensionario);
                    $sth->bindValue(':estado', $estado);
                    $sth->bindValue(':snp', $snp);
                    $sth->bindValue(':jubilacion', $jubilacion);
                    $sth->bindValue(':seguros', $seguros);
                    $sth->bindValue(':ra', $ra);
                    $sth->bindValue(':pension', $pension);
                    $sth->bindValue(':raMixta', $raMixta);
                    $sth->execute();
                    //$em->persist($afp);
                    $flush = $em->flush();
                    if ($flush == null) {
                        $status = "La afp se ha creado correctamente";
                    } else {
                        $status = "No te has registrado correctamente";
                    }
                }
            } else {
                $status = "No te has registrado correctamente";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("afp_index");
        }
        return $this->render('@Planilla/afp/add.html.twig', ["form" => $form->createView()]);
    }

    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $afp_repo = $em->getRepository("PlanillaBundle:Afp");
        $afp = $afp_repo->find($id);

        $form = $this->createForm(AfpEditType::class, $afp);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $afp->setNombre($form->get("nombre")->getData());
                $afp->setEstado($form->get("estado")->getData());
                $afp->setRegimenPensionario($form->get("regimenPensionario")->getData());
                $afp->setSnp($form->get("snp")->getData());
                $afp->setJubilacion($form->get("jubilacion")->getData());
                $afp->setSeguros($form->get("seguros")->getData());
                $afp->setRa($form->get("ra")->getData());
                $afp->setPension($form->get("pension")->getData());
                $afp->setRaMixta($form->get("raMixta")->getData());

                $em = $this->getDoctrine()->getManager();
                $em->persist($afp);
                $flush = $em->flush();
                if ($flush == null) {
                    $status = "La afp se ha editado correctamente";
                } else {
                    $status = "Error al editar afp!!";
                }
            } else {
                $status = "La afp no se ha editado, porque el formulario no es válido!!";
            }

            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("afp_index");
        }
        return $this->render('@Planilla/afp/edit.html.twig', ["form" => $form->createView()]);
    }

}

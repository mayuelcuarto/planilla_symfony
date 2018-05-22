<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Usuario;
use PlanillaBundle\Entity\Mes;
use PlanillaBundle\Entity\Planilla;
use PlanillaBundle\Entity\PlanillaHasConcepto;

class PlanillaRepository extends EntityRepository {

    public function GeneracionPlanilla($anoEjeOrigen, Mes $mesEjeOrigen, Usuario $usuario) {
        $em = $this->getEntityManager();
        $anoEje = date("Y");
        $mes_repo = $em->getRepository("PlanillaBundle:Mes");
        $mesEje = $mes_repo->findOneBy(["mesEje" => \date("m")]);

        $sth1 = $em->getConnection()->prepare("DELETE FROM planilla WHERE ano_eje = :anoEjeActual AND mes_eje = :mesEjeActual");
        $sth1->bindValue(':anoEjeActual', $anoEje);
        $sth1->bindValue(':mesEjeActual', $mesEje->getMesEje());
        $sth1->execute();

        $planilla_repo = $em->getRepository("PlanillaBundle:Planilla");
        $planilla_has_concepto_repo = $em->getRepository("PlanillaBundle:PlanillaHasConcepto");
        $planillas = $planilla_repo->findBy(["anoEje" => $anoEjeOrigen, "mesEje" => $mesEjeOrigen]);
        foreach ($planillas as $planilla) {
            $planilla_has_conceptos = $planilla_has_concepto_repo->findBy(["planilla" => $planilla]);
            $planilla_new = new Planilla();
            $planilla_new->setAnoEje($anoEje);
            $planilla_new->setMesEje($mesEje);
            $planilla_new->setFuente($planilla->getFuente());
            $planilla_new->setEspecifica($planilla->getPlazaHistorial()->getPlaza()->getEspecifica());
            $planilla_new->setSecFunc($planilla->getPlazaHistorial()->getPlaza()->getSecFunc());
            $planilla_new->setPlazaHistorial($planilla->getPlazaHistorial());
            $planilla_new->setNota($planilla->getNota());
            $planilla_new->setUsuario($usuario);
            $planilla_new->setFechaGeneracion(new \DateTime('now'));
            $planilla_new->setFechaPago(new \DateTime('now'));
            $planilla_new->setFechaIng(new \DateTime('now'));
            $planilla_new->setRemAseg($planilla->getRemAseg());
            $planilla_new->setRemNoaseg($planilla->getRemNoaseg());
            $planilla_new->setTotalEgreso($planilla->getTotalEgreso());
            $planilla_new->setPatronal($planilla->getPatronal());
            $planilla_new->setTardanzas($planilla->getTardanzas());
            $planilla_new->setParticulares($planilla->getParticulares());
            $planilla_new->setLsgh($planilla->getLsgh());
            $planilla_new->setFaltas($planilla->getFaltas());
            $em->persist($planilla_new);
            foreach ($planilla_has_conceptos as $phc) {
                $phc_new = new PlanillaHasConcepto();
                $phc_new->setPlanilla($planilla_new);
                $phc_new->setConcepto($phc->getConcepto());
                $phc_new->setFechaIng($phc->getFechaIng());
                $phc_new->setMonto($phc->getMonto());
                $phc_new->setUsuario($usuario);
                $em->persist($phc_new);
            }
        }
    }

    public function PlanillaFechas($tipoPlanillaId, $fechaGeneracion, $fechaPago) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL ActualizarPlanillaFechas(:tipoPlanillaId, :fechaGeneracion, :fechaPago)");
        $sth->bindValue(':tipoPlanillaId', $tipoPlanillaId);
        $fechaGeneracionFormat = $fechaGeneracion->format('Y-m-d');
        $sth->bindValue(':fechaGeneracion', $fechaGeneracionFormat);
        $fechaPagoFormat = $fechaPago->format('Y-m-d');
        $sth->bindValue(':fechaPago', $fechaPagoFormat);
        $sth->execute();
    }

}

<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Mes;
use PlanillaBundle\Entity\TipoPlanilla;

class EspecificaRepository extends EntityRepository {

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT e FROM PlanillaBundle:Especifica e 
                                       WHERE 
                                       e.estado = :estado OR 
                                       e.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

    public function findArrayByAnoMesTP($anoEje, Mes $mesEje, TipoPlanilla $tipoPlanilla) {
        return $this->getEntityManager()
                        ->createQuery("SELECT DISTINCT(e.especifica) AS especifica, e.nombre AS nombre, e.anoEje AS anoEje, e.id AS id FROM PlanillaBundle:Planilla p
                                       INNER JOIN p.plazaHistorial ph
                                       INNER JOIN ph.plaza pl
                                       INNER JOIN p.especifica e
                                       WHERE 
                                       p.anoEje = :anoEje AND 
                                       p.mesEje = :mesEje AND 
                                       pl.tipoPlanilla = :tipoPlanilla")
                        ->setParameter('anoEje', $anoEje)
                        ->setParameter('mesEje', $mesEje)
                        ->setParameter('tipoPlanilla', $tipoPlanilla)
                        ->getArrayResult();
    }
    
    public function findArrayByAnoMes($anoEje, Mes $mesEje) {
        return $this->getEntityManager()
                        ->createQuery("SELECT DISTINCT(e.especifica) AS especifica, e.nombre AS nombre, e.anoEje AS anoEje, e.id AS id FROM PlanillaBundle:Planilla p
                                       INNER JOIN p.plazaHistorial ph
                                       INNER JOIN ph.plaza pl
                                       INNER JOIN p.especifica e
                                       WHERE 
                                       p.anoEje = :anoEje AND 
                                       p.mesEje = :mesEje")
                        ->setParameter('anoEje', $anoEje)
                        ->setParameter('mesEje', $mesEje)
                        ->getArrayResult();
    }
}

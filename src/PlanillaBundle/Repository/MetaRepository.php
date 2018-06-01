<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Mes;
use PlanillaBundle\Entity\Especifica;

class MetaRepository extends EntityRepository {

    public function findBySecfuncEstado($secFunc, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT m FROM PlanillaBundle:Meta m 
                                       WHERE 
                                       m.estado = :estado OR 
                                       m.secFunc = :meta")
                        ->setParameter('meta', $secFunc)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

    public function findDistinctMetasEsp($anoEje, Mes $mesEje, Especifica $especifica) {
        return $this->getEntityManager()
                        ->createQuery("SELECT DISTINCT(m.secFunc) AS secfunc, m.nombre AS nombre, a.actProy as actProy FROM PlanillaBundle:Planilla p
                                       INNER JOIN p.secFunc m
                                       INNER JOIN m.actProy a
                                       WHERE 
                                       p.anoEje = :anoEje AND 
                                       p.mesEje = :mesEje AND
                                       p.especifica = :especifica
                                       ORDER BY a.actProy")
                        ->setParameter('anoEje', $anoEje)
                        ->setParameter('mesEje', $mesEje)
                        ->setParameter('especifica', $especifica)
                        ->getResult();
    }
}

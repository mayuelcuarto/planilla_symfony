<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MetaRepository extends EntityRepository {

    public function findBySecfuncEstado($secFunc, $estado) {
        return $this->getEntityManager()
                        ->createQuery(
                                "SELECT m FROM PlanillaBundle:Meta m 
                                        WHERE 
                                        m.estado = :estado OR 
                                        m.secFunc = :meta")
                        ->setParameter('meta', $secFunc)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

}

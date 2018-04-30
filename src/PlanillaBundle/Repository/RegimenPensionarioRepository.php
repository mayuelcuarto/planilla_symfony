<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RegimenPensionarioRepository extends EntityRepository {

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT r FROM PlanillaBundle:RegimenPensionario r 
                                       WHERE 
                                       r.estado = :estado OR 
                                       r.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }
}

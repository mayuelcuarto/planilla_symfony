<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class DivfuncRepository extends EntityRepository {

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT d FROM PlanillaBundle:Divfunc d 
                                       WHERE 
                                       d.estado = :estado OR 
                                       d.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

}

<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

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

}

<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UnidadRepository extends EntityRepository {

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT u FROM PlanillaBundle:Unidad u 
                                       WHERE 
                                       u.estado = :estado OR 
                                       u.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

}

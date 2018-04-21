<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GrpfRepository extends EntityRepository {

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT g FROM PlanillaBundle:Grpf g 
                                       WHERE 
                                       g.estado = :estado OR 
                                       g.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

}

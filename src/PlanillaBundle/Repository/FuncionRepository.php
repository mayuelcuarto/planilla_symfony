<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FuncionRepository extends EntityRepository {

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT f FROM PlanillaBundle:Funcion f 
                                       WHERE 
                                       f.estado = :estado OR 
                                       f.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

}

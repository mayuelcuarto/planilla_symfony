<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductoRepository extends EntityRepository {

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT p FROM PlanillaBundle:Producto p 
                                       WHERE 
                                       p.estado = :estado OR 
                                       p.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

}

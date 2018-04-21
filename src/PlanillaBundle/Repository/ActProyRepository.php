<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ActProyRepository extends EntityRepository {

    public function findByMajorToAnoEje($anoEje) {
        return $this->getEntityManager()
                        ->createQuery("SELECT a FROM PlanillaBundle:ActProy a WHERE a.anoEje > :anoEje")
                        ->setParameter('anoEje', $anoEje)
                        ->getResult();
    }

    public function findByIdEstado($id, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT a FROM PlanillaBundle:ActProy a 
                                       WHERE 
                                       a.estado = :estado OR 
                                       a.id = :id")
                        ->setParameter('id', $id)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }
}

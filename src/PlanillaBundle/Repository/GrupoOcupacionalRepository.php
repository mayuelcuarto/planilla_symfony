<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GrupoOcupacionalRepository extends EntityRepository {

    public function findByGrupoEstado($grupo, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT g FROM PlanillaBundle:GrupoOcupacional g 
                                       WHERE 
                                       g.estado = :estado OR 
                                       g.grupoOcupacional = :grupo")
                        ->setParameter('grupo', $grupo)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }

}

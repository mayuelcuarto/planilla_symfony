<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoriaOcupacionalRepository extends EntityRepository {

    public function findArrayByGrupo($grupo) {
        return $this->getEntityManager()
                        ->createQuery(
                                "SELECT c FROM PlanillaBundle:CategoriaOcupacional c 
                                   WHERE c.grupoOcupacional = :grupo ")
                        ->setParameter('grupo', $grupo)
                        ->getArrayResult();
    }

}

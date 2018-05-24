<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FuenteFinancRepository extends EntityRepository {

    public function findArrayByAnoEje($anoEje) {
        return $this->getEntityManager()
                        ->createQuery("SELECT f FROM PlanillaBundle:FuenteFinanc f 
                                       WHERE 
                                       f.anoEje = :anoEje")
                        ->setParameter('anoEje', $anoEje)
                        ->getArrayResult();
    }

}

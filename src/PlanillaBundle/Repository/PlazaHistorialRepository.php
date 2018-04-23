<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\TipoPlanilla;

class PlazaHistorialRepository extends EntityRepository {

    public function findArrayByTipoPlanillaAnoEjeMesEje(TipoPlanilla $tipoPlanilla, $anoEje, $mesEje) {
        return $this->getEntityManager()
                        ->createQuery("SELECT ph, pe FROM PlanillaBundle:PlazaHistorial ph 
                                       INNER JOIN ph.plaza pl
                                       INNER JOIN ph.codPersonal pe 
                                       WHERE 
                                       pl.tipoPlanilla = :tipoPlanilla AND 
                                       ph.estado = 1 AND
                                       ph.id NOT IN 
                                       (SELECT ph2.id
                                        FROM PlanillaBundle:Planilla p 
                                        INNER JOIN p.plazaHistorial ph2
                                        WHERE p.anoEje = :anoEje AND
                                        p.mesEje = :mesEje)
                                       ORDER BY pe.apellidoPaterno")
                        ->setParameter('tipoPlanilla', $tipoPlanilla)
                        ->setParameter('anoEje', $anoEje)
                        ->setParameter('mesEje', $mesEje)
                        ->getArrayResult();
    }

    public function findByTipoPlanillaAnoEjeMesEje(TipoPlanilla $tipoPlanilla, $anoEje, $mesEje) {
        return $this->getEntityManager()
                        ->createQuery("SELECT ph, pe FROM PlanillaBundle:PlazaHistorial ph 
                                       INNER JOIN ph.plaza pl
                                       INNER JOIN ph.codPersonal pe 
                                       WHERE 
                                       pl.tipoPlanilla = :tipoPlanilla AND 
                                       ph.estado = 1 AND
                                       ph.id NOT IN 
                                       (SELECT ph2.id
                                        FROM PlanillaBundle:Planilla p 
                                        INNER JOIN p.plazaHistorial ph2
                                        WHERE p.anoEje = :anoEje AND
                                        p.mesEje = :mesEje)
                                       ORDER BY pe.apellidoPaterno")
                        ->setParameter('tipoPlanilla', $tipoPlanilla)
                        ->setParameter('anoEje', $anoEje)
                        ->setParameter('mesEje', $mesEje)
                        ->getResult();
    }
}

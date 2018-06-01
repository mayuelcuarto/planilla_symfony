<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Mes;
use PlanillaBundle\Entity\Especifica;
use PlanillaBundle\Entity\TipoConcepto;

class ConceptoRepository extends EntityRepository {
    
    public function findDistinctMetasEspTC($anoEje, Mes $mesEje, Especifica $especifica, TipoConcepto $tipoConcepto) {
        return $this->getEntityManager()
                        ->createQuery("SELECT DISTINCT(c.id) AS id, c.concepto AS concepto, c.abreviatura AS abreviatura
                                       FROM PlanillaBundle:PlanillaHasConcepto phc
                                       INNER JOIN phc.planilla p
                                       INNER JOIN phc.concepto c
                                       WHERE 
                                       p.anoEje = :anoEje AND 
                                       p.mesEje = :mesEje AND
                                       p.especifica = :especifica AND 
                                       c.tipoConcepto = :tipoConcepto
                                       ORDER BY c.id")
                        ->setParameter('anoEje', $anoEje)
                        ->setParameter('mesEje', $mesEje)
                        ->setParameter('especifica', $especifica)
                        ->setParameter('tipoConcepto', $tipoConcepto)
                        ->getResult();
    }
}

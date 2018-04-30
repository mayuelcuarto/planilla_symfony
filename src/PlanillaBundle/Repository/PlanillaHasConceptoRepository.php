<?php
namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Planilla;
use PlanillaBundle\Entity\TipoConcepto;

class PlanillaHasConceptoRepository extends EntityRepository {

    public function findArrayByPlanillaTipoConcepto(Planilla $planilla, TipoConcepto $tipoConcepto) {
        $es_activo = 0;
        $es_pensionista = 0;
        switch($planilla->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getId()){
            case 1:
                $es_activo = 1;
                break;
            case 2:
                $es_pensionista = 1;
                break;
            case 3:
                $es_pensionista = 1;
                break;
            case 4:
                $es_activo = 1;
        }
        
        return $this->getEntityManager()
                        ->createQuery("SELECT c FROM PlanillaBundle:Concepto c
                                       WHERE 
                                       c.tipoConcepto = :tipoConcepto AND 
                                       c.estado = 1 AND 
                                       (c.esActivo = :esActivo OR c.esPension = :esPensionista) AND
                                       c.id NOT IN 
                                       (SELECT c2.id
                                        FROM PlanillaBundle:PlanillaHasConcepto phc 
                                        INNER JOIN phc.concepto c2
                                        WHERE phc.planilla = :planilla)")
                        ->setParameter('planilla', $planilla)
                        ->setParameter('tipoConcepto', $tipoConcepto)
                        ->setParameter('esActivo', $es_activo)
                        ->setParameter('esPensionista', $es_pensionista)
                        ->getArrayResult();
    }
    
    public function findByPlanillaTipoConcepto(Planilla $planilla, TipoConcepto $tipoConcepto) {
        $es_activo = 0;
        $es_pensionista = 0;
        switch($planilla->getPlazaHistorial()->getPlaza()->getTipoPlanilla()->getId()){
            case 1:
                $es_activo = 1;
                break;
            case 2:
                $es_pensionista = 1;
                break;
            case 3:
                $es_pensionista = 1;
                break;
            case 4:
                $es_activo = 1;
        }
        
        return $this->getEntityManager()
                        ->createQuery("SELECT c FROM PlanillaBundle:Concepto c
                                       WHERE 
                                       c.tipoConcepto = :tipoConcepto AND 
                                       c.estado = 1 AND 
                                       (c.esActivo = :esActivo OR c.esPension = :esPensionista) AND
                                       c.id NOT IN 
                                       (SELECT c2.id
                                        FROM PlanillaBundle:PlanillaHasConcepto phc 
                                        INNER JOIN phc.concepto c2
                                        WHERE phc.planilla = :planilla)")
                        ->setParameter('planilla', $planilla)
                        ->setParameter('tipoConcepto', $tipoConcepto)
                        ->setParameter('esActivo', $es_activo)
                        ->setParameter('esPensionista', $es_pensionista)
                        ->getResult();
    }
    
    public function ActualizarPlanillaAfp(Planilla $planilla) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL ActualizarPlanillaAfp(:planillaId)");
        $sth->bindValue(':planillaId', $planilla->getId());
        $sth->execute();
    }
}


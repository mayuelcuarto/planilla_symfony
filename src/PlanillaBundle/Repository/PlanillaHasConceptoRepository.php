<?php
namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Planilla;
use PlanillaBundle\Entity\TipoConcepto;
use PlanillaBundle\Entity\Mes;
use PlanillaBundle\Entity\TipoPlanilla;
use PlanillaBundle\Entity\FuenteFinanc;
use PlanillaBundle\Entity\Concepto;
use PlanillaBundle\Entity\Meta;
use PlanillaBundle\Entity\Especifica;
use PlanillaBundle\Entity\Afp;
use PDO;

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
    
    public function ActualizarInasistencias(Planilla $planilla) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL ActualizarInasistencias(:planillaId)");
        $sth->bindValue(':planillaId', $planilla->getId());
        $sth->execute();
    }
    
    public function ActualizarEsSalud(Planilla $planilla) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL ActualizarEsSalud(:planillaId)");
        $sth->bindValue(':planillaId', $planilla->getId());
        $sth->execute();
    }
    
    public function SumaConcepto($anoEje, Mes $mesEje, TipoPlanilla $tipoPlanilla, FuenteFinanc $fuente, Concepto $concepto) {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SumaConcepto(:anoEje, :mesEje, :tipoPlanilla, :fuente, :concepto)");
        $sth1->bindValue(':anoEje', $anoEje);
        $sth1->bindValue(':mesEje', $mesEje->getMesEje());
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla->getId());
        $sth1->bindValue(':fuente', $fuente->getId());
        $sth1->bindValue(':concepto', $concepto->getId());
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $sumaConcepto = $fila[0];
        }
        return $sumaConcepto;
    }
    
    public function SumaConceptoMetaEsp($anoEje, Mes $mesEje, TipoPlanilla $tipoPlanilla, Meta $meta, Especifica $especifica, Concepto $concepto) {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SumaConceptoMetaEsp(:anoEje, :mesEje, :tipoPlanilla, :meta, :especifica, :concepto)");
        $sth1->bindValue(':anoEje', $anoEje);
        $sth1->bindValue(':mesEje', $mesEje->getMesEje());
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla->getId());
        $sth1->bindValue(':meta', $meta->getSecFunc());
        $sth1->bindValue(':especifica', $especifica->getId());
        $sth1->bindValue(':concepto', $concepto->getId());
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $sumaConcepto = $fila[0];
        }
        return $sumaConcepto;
    }
    
    public function SumaConceptoEsp($anoEje, Mes $mesEje, TipoPlanilla $tipoPlanilla, Especifica $especifica, Concepto $concepto) {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SumaConceptoEsp(:anoEje, :mesEje, :tipoPlanilla, :especifica, :concepto)");
        $sth1->bindValue(':anoEje', $anoEje);
        $sth1->bindValue(':mesEje', $mesEje->getMesEje());
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla->getId());
        $sth1->bindValue(':especifica', $especifica->getId());
        $sth1->bindValue(':concepto', $concepto->getId());
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $sumaConcepto = $fila[0];
        }
        return $sumaConcepto;
    }
    
    public function SumaConceptoAfp($anoEje, Mes $mesEje, TipoPlanilla $tipoPlanilla, FuenteFinanc $fuente, Afp $afp, Concepto $concepto) {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SumaConceptoAfp(:anoEje, :mesEje, :tipoPlanilla, :fuente, :afp, :concepto)");
        $sth1->bindValue(':anoEje', $anoEje);
        $sth1->bindValue(':mesEje', $mesEje->getMesEje());
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla->getId());
        $sth1->bindValue(':fuente', $fuente->getId());
        $sth1->bindValue(':afp', $afp->getId());
        $sth1->bindValue(':concepto', $concepto->getId());
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $sumaConcepto = $fila[0];
        }
        return $sumaConcepto;
    }
    
    public function SumaConceptoAfpRA($anoEje, Mes $mesEje, TipoPlanilla $tipoPlanilla, FuenteFinanc $fuente, Afp $afp, Concepto $concepto, $raTipo) {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SumaConceptoAfpRA(:anoEje, :mesEje, :tipoPlanilla, :fuente, :afp, :concepto, :raTipo)");
        $sth1->bindValue(':anoEje', $anoEje);
        $sth1->bindValue(':mesEje', $mesEje->getMesEje());
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla->getId());
        $sth1->bindValue(':fuente', $fuente->getId());
        $sth1->bindValue(':afp', $afp->getId());
        $sth1->bindValue(':concepto', $concepto->getId());
        $sth1->bindValue(':raTipo', $raTipo);
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $sumaConcepto = $fila[0];
        }
        return $sumaConcepto;
    }
}


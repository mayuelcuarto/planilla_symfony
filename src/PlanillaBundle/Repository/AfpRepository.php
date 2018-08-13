<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Afp;
use PlanillaBundle\Entity\RegimenPensionario;
use PlanillaBundle\Entity\Mes;
use PlanillaBundle\Entity\TipoPlanilla;
use PlanillaBundle\Entity\FuenteFinanc;
use PDO;

class AfpRepository extends EntityRepository {

    public function sugerirAfp() {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirAfp()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM)) {
            $afp_id = $fila[0];
        }
        return $afp_id;
    }

    public function AgregarAfp(Afp $afp) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL AgregarAFP(:id, :nombre, :regimenPensionario, :estado, :snp, :jubilacion, :seguros, :ra, :pension, :raMixta)");
        $sth->bindValue(':id', $afp->getId());
        $sth->bindValue(':nombre', $afp->getNombre());
        $sth->bindValue(':regimenPensionario', $afp->getRegimenPensionario()->getId());
        $sth->bindValue(':estado', $afp->getEstado());
        $sth->bindValue(':snp', $afp->getSnp());
        $sth->bindValue(':jubilacion', $afp->getJubilacion());
        $sth->bindValue(':seguros', $afp->getSeguros());
        $sth->bindValue(':ra', $afp->getRa());
        $sth->bindValue(':pension', $afp->getPension());
        $sth->bindValue(':raMixta', $afp->getRaMixta());
        $sth->execute();
    }

    public function findArrayByRegPen(RegimenPensionario $regimenPensionario) {
        return $this->getEntityManager()
                        ->createQuery("SELECT a FROM PlanillaBundle:Afp a 
                                       WHERE 
                                       a.regimenPensionario = :regimenPensionario AND 
                                       a.estado = 1")
                        ->setParameter('regimenPensionario', $regimenPensionario)
                        ->getArrayResult();
    }

    public function findDistinctByAnoMesTipoFuente($anoEje, Mes $mesEje, TipoPlanilla $tipoPlanilla, FuenteFinanc $fuente) {
        return $this->getEntityManager()
                        ->createQuery("SELECT DISTINCT(a.id) AS id, a.nombre AS nombre, a.jubilacion AS jubilacion, a.seguros AS seguros, a.ra AS ra, a.raMixta AS raMixta
                                       FROM PlanillaBundle:Planilla p
                                       INNER JOIN p.plazaHistorial ph
                                       INNER JOIN ph.plaza pl
                                       INNER JOIN ph.afp a
                                       WHERE 
                                       p.anoEje = :anoEje AND 
                                       p.mesEje = :mesEje AND
                                       p.fuente = :fuente AND 
                                       pl.tipoPlanilla = :tipoPlanilla
                                       ORDER BY a.id")
                        ->setParameter('anoEje', $anoEje)
                        ->setParameter('mesEje', $mesEje)
                        ->setParameter('fuente', $fuente)
                        ->setParameter('tipoPlanilla', $tipoPlanilla)
                        ->getResult();
    }
}

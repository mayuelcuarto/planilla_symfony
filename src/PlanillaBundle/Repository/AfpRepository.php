<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\Afp;
use PDO;

class AfpRepository extends EntityRepository {

    public function sugerirAfp() {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirAfp()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
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

}

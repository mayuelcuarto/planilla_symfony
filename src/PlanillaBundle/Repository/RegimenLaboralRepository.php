<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\RegimenLaboral;
use PDO;

class RegimenLaboralRepository extends EntityRepository {

    public function sugerirRegimenLaboral() {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirRegimenLaboral()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $regimenLaboral_id = $fila[0];
        }
        return $regimenLaboral_id;
    }

    public function AgregarRegimenLaboral(RegimenLaboral $regimenLaboral) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL AgregarRegimenLaboral(:id, :nombre, :descripcion, :sueldoMinimo, :estado)");
        $sth->bindValue(':id', $regimenLaboral->getId());
        $sth->bindValue(':nombre', $regimenLaboral->getNombre());
        $sth->bindValue(':descripcion', $regimenLaboral->getDescripcion());
        $sth->bindValue(':sueldoMinimo', $regimenLaboral->getSueldoMinimo());
        $sth->bindValue(':estado', $regimenLaboral->getEstado());
        $sth->execute();
    }

}

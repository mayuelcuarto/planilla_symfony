<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\CondicionLaboral;
use PDO;

class CondicionLaboralRepository extends EntityRepository {
    
    public function sugerirCondicionLaboral(){
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirCondicionLaboral()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM)) {
            $condicionId = $fila[0];
        }
        return $condicionId;
    }

    public function AgregarCondicionLaboral(CondicionLaboral $condicionlaboral) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL AgregarCondicionLaboral(:id, :nombre, :estado)");
        $sth->bindValue(':id', $condicionlaboral->getId());
        $sth->bindValue(':nombre', $condicionlaboral->getNombre());
        $sth->bindValue(':estado', $condicionlaboral->getEstado());
        $sth->execute();
    }
}

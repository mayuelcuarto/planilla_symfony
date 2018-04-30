<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\GrupoOcupacional;
use PDO;

class GrupoOcupacionalRepository extends EntityRepository {

    public function findByGrupoEstado($grupo, $estado) {
        return $this->getEntityManager()
                        ->createQuery("SELECT g FROM PlanillaBundle:GrupoOcupacional g 
                                       WHERE 
                                       g.estado = :estado OR 
                                       g.grupoOcupacional = :grupo")
                        ->setParameter('grupo', $grupo)
                        ->setParameter('estado', $estado)
                        ->getResult();
    }
    
    public function sugerirGrupoOcupacional(){
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirGrupoOcupacional()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $grupoId = $fila[0];
        }
        return $grupoId;
    }
    
    
    public function AgregarGrupoOcupacional(GrupoOcupacional $grupoOcupacional) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL AgregarGrupoOcupacional(:id, :nombre, :estado)");
        $sth->bindValue(':id', $grupoOcupacional->getGrupoOcupacional());
        $sth->bindValue(':nombre', $grupoOcupacional->getNombre());
        $sth->bindValue(':estado', $grupoOcupacional->getEstado());
        $sth->execute();
    }
}

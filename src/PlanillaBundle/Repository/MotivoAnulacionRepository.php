<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlanillaBundle\Entity\MotivoAnulacion;
use PDO;

class MotivoAnulacionRepository extends EntityRepository {

    public function sugerirMotivoAnulacion() {
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirMotivoAnulacion()");
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $motivo_id = $fila[0];
        }
        return $motivo_id;
    }

    public function AgregarMotivoAnulacion(MotivoAnulacion $motivoAnulacion) {
        $em = $this->getEntityManager();
        $sth = $em->getConnection()->prepare("CALL AgregarMotivoAnulacion(:id, :nombre, :estado)");
        $sth->bindValue(':id', $motivoAnulacion->getId());
        $sth->bindValue(':nombre', $motivoAnulacion->getNombre());
        $sth->bindValue(':estado', $motivoAnulacion->getEstado());
        $sth->execute();
    }

}

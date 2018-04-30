<?php

namespace PlanillaBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PDO;

class PlazaRepository extends EntityRepository {
    
    public function sugerirNumPlaza($tipoPlanilla){
        $em = $this->getEntityManager();
        $sth1 = $em->getConnection()->prepare("SELECT SugerirPlaza(:tipoPlanilla)");
        $sth1->bindValue(':tipoPlanilla', $tipoPlanilla);
        $sth1->execute();
        while ($fila = $sth1->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
            $numPlaza = $fila[0];
        }
        return $numPlaza;
    }

}

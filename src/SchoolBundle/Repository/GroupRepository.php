<?php

namespace SchoolBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * Class GroupRepository
 * @package SchoolBundle\Repository
 */
class GroupRepository extends EntityRepository
{

    /**
     *
     */
    public function findAll()
    {
        $sql =  "SELECT * ".
                "FROM c3csi_group g";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('SchoolBundle\Entity\Group', 'g');
        $rsm->addFieldResult('g', 'id', 'id');
        $rsm->addFieldResult('g', 'name', 'name');
        $rsm->addFieldResult('g', 'periode', 'periode');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $matieres = $query->getResult();

        return $matieres;
    }

    /**
     * @param $id
     */
    public function findOneById($id, $fullObject=true)
    {
        $sql =  "SELECT *".
                "FROM c3csi_group m WHERE id = ?";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('SchoolBundle\Entity\Group', 'g');
        $rsm->addFieldResult('g', 'id', 'id');
        $rsm->addFieldResult('g', 'name', 'name');
        $rsm->addFieldResult('g', 'periode', 'periode');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $id);
        $result = $query->getResult();

        if(isset($result[0])){
            return $result[0];
        }
        return $result;
    }

}

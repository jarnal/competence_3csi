<?php

namespace EvaluationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * Class TypeNoteRepository
 * @package EvaluationBundle\Repository
 */
class TypeNoteRepository extends EntityRepository
{

    /**
     * Returns all examens
     */
    public function findAll()
    {
        $sql =  "SELECT * ".
                "FROM c3csi_type_note tn";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('EvaluationBundle\Entity\TypeNote', 'tn');
        $rsm->addFieldResult('tn', 'id', 'id');
        $rsm->addFieldResult('tn', 'label', 'label');
        $rsm->addFieldResult('tn', 'value', 'value');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $matieres = $query->getResult();

        return $matieres;
    }

    /**
     * Returns a specific examen
     *
     * @param $id
     */
    public function findOneById($id, $fullObject=true)
    {
        $sql =  "SELECT * ".
                "FROM c3csi_type_note tn WHERE id = ?";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('EvaluationBundle\Entity\TypeNote', 'tn');
        $rsm->addFieldResult('tn', 'id', 'id');
        $rsm->addFieldResult('tn', 'label', 'label');
        $rsm->addFieldResult('tn', 'value', 'value');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $id);
        $result = $query->getResult();

        if(isset($result[0])){
            return $result[0];
        }
        return $result;
    }

}

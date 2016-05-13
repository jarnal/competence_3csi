<?php

namespace EvaluationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * GameRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvaluationIntervenantRepository extends EntityRepository
{

    /**
     * Returns all examens
     */
    public function findAll()
    {
        $sql =  "SELECT * ".
                "FROM c3csi_examen m";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('EvaluationBundle\Entity\Examen', 'e');
        $rsm->addFieldResult('e', 'id', 'id');
        $rsm->addFieldResult('e', 'name', 'name');
        $rsm->addFieldResult('e', 'description', 'description');

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
                "FROM c3csi_examen m WHERE id = ?";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('EvaluationBundle\Entity\Examen', 'm');
        $rsm->addFieldResult('m', 'id', 'id');
        $rsm->addFieldResult('m', 'name', 'name');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $id);
        $result = $query->getResult();

        if(isset($result[0])){
            return $result[0];
        }
        return $result;
    }

    /**
     * Returns the examens related to the group passed in parameter
     *
     * @param $groupID
     */
    public function findByGroupId($groupID) {
        $sql =  "SELECT exam.id, exam.name ".
                "FROM c3csi_group grp ".
                "LEFT JOIN c3csi_examen exam ON exam.group_id = grp.id ".
                "WHERE grp.id = ?";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('EvaluationBundle\Entity\Examen', 'm');
        $rsm->addFieldResult('m', 'id', 'id');
        $rsm->addFieldResult('m', 'name', 'name');
        $rsm->addFieldResult('m', 'description', 'description');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $groupID);
        $result = $query->getResult();

        return $result;
    }

    /**
     * Returns the examens related to the intervenant passed in parameter
     *
     * @param $intervenantID
     */
    public function findByIntervenantId($intervenantID) {
        $sql =  "SELECT exam.id, exam.name, exam.description ".
                "FROM c3csi_user user ".
                "LEFT JOIN c3csi_examen exam ON exam.intervenant_id = user.id ".
                "WHERE user.id = ?";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('EvaluationBundle\Entity\Examen', 'm');
        $rsm->addFieldResult('m', 'id', 'id');
        $rsm->addFieldResult('m', 'name', 'name');
        $rsm->addFieldResult('m', 'description', 'description');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $intervenantID);
        $result = $query->getResult();

        return $result;
    }

}

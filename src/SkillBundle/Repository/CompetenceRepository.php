<?php

namespace SkillBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * Class CompetenceRepository
 * @package SkillBundle\Repository
 */
class CompetenceRepository extends EntityRepository
{

    /**
     * Returns all competences
     */
    public function findAll()
    {
        $sql =  "SELECT * ".
                "FROM c3csi_competence m";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('SkillBundle\Entity\Competence', 'c');
        $rsm->addFieldResult('c', 'id', 'id');
        $rsm->addFieldResult('c', 'name', 'name');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $competences = $query->getResult();

        return $competences;
    }

    /**
     * Returns a specific competence by ID
     *
     * @param $id
     * @param bool $fullObject
     * @return array
     */
    public function findOneById($id, $fullObject=true)
    {
        $sql =  "SELECT *".
                "FROM c3csi_competence m WHERE id = ?";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('SkillBundle\Entity\Competence', 'c');
        $rsm->addFieldResult('c', 'id', 'id');
        $rsm->addFieldResult('c', 'name', 'name');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $id);
        $result = $query->getResult();

        if(isset($result[0])){
            return $result[0];
        }
        return $result;
    }

    /**
     * Returns all competences linked to the specific matiere
     *
     * @param $matiereID
     */
    public function findByMatiereId($matiereID) {
        $sql =  "SELECT c.id, c.name ".
                "FROM c3csi_matiere mat ".
                "LEFT JOIN c3csi_competence_rel_matiere comp_mat ON comp_mat.matiere_id = mat.id ".
                "LEFT JOIN c3csi_competence c ON c.id = comp_mat.competence_id ".
                "WHERE mat.id = ?";

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('SkillBundle\Entity\Competence', 'c');
        $rsm->addFieldResult('c', 'id', 'id');
        $rsm->addFieldResult('c', 'name', 'name');

        $query = $this->_em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $matiereID);
        $result = $query->getResult();
        return $result;
    }

}

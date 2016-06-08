<?php

namespace EvaluationBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use GlobalBundle\Service\EntityRestService;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class MatiereService
 * @package SchoolBundle\Entity
 *
 * Service allowing to handle matiere across the application
 */
class ExamenService extends EntityRestService
{

    /**
     * ExamenService constructor.
     * @param ObjectManager $pEntityManager
     * @param FormFactoryInterface $pFormFactory
     * @param $pEntityClass
     */
    public function __construct(ObjectManager $pEntityManager, FormFactoryInterface $pFormFactory, $pEntityClass)
    {
        parent::__construct($pEntityManager, $pFormFactory, $pEntityClass, null, null);
    }

    /**
     * Returns the examens related to the group passed in parameter
     *
     * @param $groupID
     */
    public function findByGroupId($groupID) {
        return $this->repository->findByGroupId($groupID);
    }

    /**
     * Returns the examens related to the group passed in parameter
     *
     * @param $groupID
     */
    public function findByUserId($userID) {
        return $this->repository->findByUserId($userID);
    }

    /**
     * @param $userId
     */
    public function findForCalendarByUserId($userID){
        return $this->repository->findForCalendarByUserId($userID);
    }

    /**
     * Returns the examens related to the intervenant passed in parameter
     *
     * @param $intervenantID
     */
    public function findByIntervenantId($intervenantID) {
        return $this->repository->findByIntervenantId($intervenantID);
    }

}
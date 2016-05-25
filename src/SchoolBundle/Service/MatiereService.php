<?php

namespace SchoolBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use GlobalBundle\Service\EntityRestService;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class MatiereService
 * @package SchoolBundle\Entity
 *
 * Service allowing to handle matiere across the application
 */
class MatiereService extends EntityRestService
{

    public function __construct(ObjectManager $pEntityManager, FormFactoryInterface $pFormFactory, $pEntityClass)
    {
        parent::__construct($pEntityManager, $pFormFactory, $pEntityClass, null, null);
    }

    /**
     * @param $intervantID
     * @return mixed
     */
    public function findMatieresByIntervenant($intervantID) {
        return $this->repository->findMatieresByIntervenant($intervantID);
    }

    /**
     * @param $groupID
     * @return mixed
     */
    public function findByGroupId($groupID) {
        return $this->repository->findMatieresByGroup($groupID);
    }

    /**
     * @param $userID
     * @return mixed
     */
    public function findByUserId($userID) {
        return $this->repository->findMatieresByUser($userID);
    }

}
<?php

namespace SkillBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use GlobalBundle\Service\EntityRestService;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class CompetenceService
 * @package SchoolBundle\Entity
 *
 * Service allowing to handle competences across the application
 */
class CompetenceService extends EntityRestService
{

    /**
     * Constructor
     *
     * CompetenceService constructor.
     * @param ObjectManager $pEntityManager
     * @param FormFactoryInterface $pFormFactory
     * @param $pEntityClass
     */
    public function __construct(ObjectManager $pEntityManager, FormFactoryInterface $pFormFactory, $pEntityClass)
    {
        parent::__construct($pEntityManager, $pFormFactory, $pEntityClass, null, null);
    }

    /**
     * Returns all competences related to a specific matiere
     */
    public function findByMatiereId($matiereID){
        return $this->repository->findByMatiereId($matiereID);
    }

}
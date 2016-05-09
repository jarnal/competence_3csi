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
     */
    public function findMatieresByIntervenant($intervantID) {
        return $this->repository->findMatieresByIntervenant($intervantID);
    }

}
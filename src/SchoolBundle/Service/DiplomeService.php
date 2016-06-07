<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 06/06/2016
 * Time: 11:25
 */

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
class DiplomeService extends EntityRestService
{

    public function __construct(ObjectManager $pEntityManager, FormFactoryInterface $pFormFactory, $pEntityClass)
    {
        parent::__construct($pEntityManager, $pFormFactory, $pEntityClass, null, null);
    }

    /**
     * @param $userID
     * @return mixed
     */
    public function findByUserId($userID) {
        return $this->repository->findByUser($userID);
    }

}
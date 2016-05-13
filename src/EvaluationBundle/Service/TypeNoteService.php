<?php

namespace EvaluationBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use GlobalBundle\Service\EntityRestService;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class TypeNoteService
 * @package EvaluationBundle\Entity
 *
 * Service allowing to handle type note across the application
 */
class TypeNoteService extends EntityRestService
{

    /**
     * TypeNoteService constructor.
     * @param ObjectManager $pEntityManager
     * @param FormFactoryInterface $pFormFactory
     * @param $pEntityClass
     */
    public function __construct(ObjectManager $pEntityManager, FormFactoryInterface $pFormFactory, $pEntityClass)
    {
        parent::__construct($pEntityManager, $pFormFactory, $pEntityClass, null, null);
    }

    /**
     * @param $value
     */
    public function findOneByValue($value){
        return $this->repository->findOneByValue($value);
    }

}
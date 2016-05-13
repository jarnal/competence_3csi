<?php

namespace PeopleBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use PeopleBundle\Entity\User;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use GlobalBundle\Service\EntityRestService;

/**
 * Class UserService
 * @package PeopleBundle\Service
 *
 * Service allowing to handle users across the application
 */
class UserService extends EntityRestService
{

    protected $encoderFactory;

    /**
     * Constructor
     *
     * @param ObjectManager $pEntityManager
     * @param FormFactoryInterface $pFormFactory
     * @param $pEntityClass
     * @param $pFormTypeClass
     * @param $pFormExceptionClass
     */
    public function __construct(ObjectManager $pEntityManager, FormFactoryInterface $pFormFactory, $pEntityClass, $pFormTypeClass, $pFormExceptionClass, EncoderFactory $pEncoderFactory)
    {
        $this->encoderFactory = $pEncoderFactory;
        parent::__construct($pEntityManager, $pFormFactory, $pEntityClass, $pFormTypeClass, $pFormExceptionClass);
    }

    /**
     * {@inheritdoc}
     */
    protected function processForm($entity, array $pParameters, $pMethod = "PUT")
    {
        $form = $this->formFactory->create(new $this->formType(), $entity, array('method' => $pMethod));
        $form->submit($pParameters, 'PUT'!=$pMethod);

        $factory = $this->encoderFactory;
        $encoder = $factory->getEncoder($entity);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);

        if ($this->isFormValid($form)) {

            $entity = $form->getData();
            $this->em->persist($entity);
            $this->em->flush($entity);

            return $entity;
        }

        throw new $this->formException('Invalid submitted data', $form);
    }

    /**
     * @param $userList
     * @param $competenceList
     */
    public function findByListWithEvaluations($userList, $competenceList){
        return $this->repository->findByListWithEvaluations($userList, $competenceList);
    }

    /**
     * Returns the users related to the group passed in parameter
     *
     * @param $groupID
     */
    public function findByGroupId($groupID) {
        return $this->repository->findByGroupId($groupID);
    }

    /**
     * Returns a user by his username and password.
     *
     * @param $login
     * @param $password
     * @return object
     */
    public function getByLoginPassword($login, $password)
    {
        $entity = $this->repository->findOneBy(array("username"=>$login));
        $factory = $this->encoderFactory;
        $encoder = $factory->getEncoder($entity);
        $isPwdValid = $encoder->isPasswordValid( $entity->getPassword(), $password, $entity->getSalt() );

        return $isPwdValid? $entity : false;
    }

    /**
     * Returns a user or a NotFoundHttpException depending if user exists or not.
     *
     * @param $login
     * @param $password
     * @return User
     */
    public function getByLoginPasswordOr404($login, $password)
    {
        if (!($entity = $this->getByLoginPassword($login, $password))) {
            throw new NotFoundHttpException(sprintf('The player \'%s\' was not found.',$login));
        }

        return $entity;
    }

}
<?php

namespace RestSecurityBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use PeopleBundle\Service\UserService;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Link;
use FOS\RestBundle\Controller\Annotations\Unlink;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Acl\Exception\Exception;
use GlobalBundle\Abstraction\EntityServiceInterface;
//use TeamManager\EventBundle\Entity\Game;
use PeopleBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use PeopleBundle\Abstraction\SpecificUserInterface;
use PeopleBundle\Exception\InvalidUserFormException;
use PeopleBundle\Form\UserType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class SecurityRestController extends FOSRestController
{

    /**
     * Before client can start calling the API, a user has to be logged in the app.
     * This methods returns, if the user credentials are right, the unique api_key for this user.
     * This way is more secure than passing an id, because it's easier to guess an id than a long string like this one.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Security API"
     * )
     *
     * @View(serializerGroups={"PlayerGlobal"})
     *
     * @POST("/security", name="credentials", options={"method_prefix"=false})
     */
    public function credentialsAction(Request $request)
    {
        $user_login = $request->request->get('user_l');
        $user_pwd = $request->request->get('user_p');

        $userEntity = $this->getService()->getByLoginPasswordOr404($user_login, $user_pwd);

        $arr = array(
            "api_key"=>$userEntity->getApiKey(),
            "user_id"=>$userEntity->getId(),
            "user_name" => $userEntity->getFirstname()." ".$userEntity->getLastname(),
            "user_role" => $userEntity->getRoles()[0]
        );
        $response = new JSONResponse($arr);
        return $response;
    }

    /**
     * Returns the appropriate service to handle related entity.
     *
     * @return UserService
     */
    protected function getService()
    {
        return $this->container->get('people_bundle.service.user');
    }

}

<?php

namespace PeopleBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use GlobalBundle\Abstraction\EntityServiceInterface;
use PeopleBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use PeopleBundle\Abstraction\SpecificUserInterface;
use PeopleBundle\Exception\InvalidUserFormException;
use PeopleBundle\Form\UserType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserRestController extends FOSRestController
{

    /**
     * Returns all users.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="User API",
     *  output={
     *      "class"="PeopleBundle\Entity\User",
     *      "collection"=true,
     *      "collectionName" = "users",
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      }
     *  }
     * )
     *
     * @View( serializerGroups={ "UserGlobal" } )
     *
     * @Get("/", name="get_all", options={ "method_prefix" = false })
     *
     * @return array
     */
    public function getAllAction()
    {
        //if( $this->getUser() ){
            return array("users"=>$this->getService()->getAll());
        /*}
        return 1;*/
    }

    /**
     * Returns a user by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="User API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="User id"
     *      }
     *  },
     *  output={
     *      "class"="\PeopleBundle\Entity\User",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when user exists",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"UserDetails"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return User
     */
    public function getAction($id)
    {
        $test = $this->getService()->getOr404($id);
        return $test;
    }

    /**
     * Returns a user by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="User API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="User id"
     *      }
     *  },
     *  output={
     *      "class"="\PeopleBundle\Entity\User",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when user exists",
     *     404 = "Returned when the user is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/ulist/{users_id}/clist/{competences_id}", name="get_note_by_competence", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return User
     */
    public function listCompetencesByUsersListAction($users_id, $competences_id){
        $usersList = json_decode($users_id);
        $competencesList = json_decode($competences_id);

        $result = $this->getService()->findByListWithEvaluations($usersList, $competencesList);

        return $result;
    }

    /**
     * Adds a new user.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="User API",
     *  input="PeopleBundle\Form\UserType",
     *  statusCodes = {
     *      200 = "Returned when the user has been created",
     *      400 = "Returned when the user form has errors"
     *  }
     * )
     *
     * @View(
     *  serializerGroups={"Default"},
     *  template="PeopleBundle:User:userForm.html.twig",
     *  statusCode= Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @Post("/" , name="post", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface|View
     *
     */
    public function postAction(Request $request)
    {
        return $request->request;
        /*try {
            $form = new UserType();
            $user = $this->getService()->post(
                $request->request->get($form->getName())
            );

            $routeOptions = array(
                'id' => $user->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_user_get', $routeOptions, Codes::HTTP_CREATED);
        } catch (InvalidUserFormException $exception) {
            return $exception->getForm();
        }*/
    }

    /**
     * Builds the form to use to create a new user.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="User API",
     *  statusCodes = {
     *    200 = "Returned when successful"
     *  }
     * )
     *
     * @View(
     *  template="PeopleBundle:User:userForm.html.twig",
     *  templateVar = "form"
     * )
     *
     * @Get("/new", name="new", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface
     */
    public function newAction()
    {
        return $this->createForm(new UserType(), null, array(
            "action" => $this->generateUrl('api_user_post', array("access_token"=>$_GET["access_token"])),
            "method" => "POST"
        ));
    }

    /**
     * Update existing user from the submitted data or create a new user with a specific id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="User API",
     *  input="PeopleBundle\Form\UserType",
     *  statusCodes = {
     *     201 = "Returned when a new User is created",
     *     204 = "Returned when User has been updated successfully",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @View(
     *  serializerGroups={"Default"},
     *  template="PeopleBundle:User:userEditForm.html.twig",
     * )
     *
     * @Put("/{id}", name="put", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface|View
     */
    public function putAction(Request $request, $id)
    {
        $service = $this->getService();
        try {
            $form = new UserType();
            if ( !($user = $service->get($id)) ) {
                $user = $service->post(
                    $request->request->get($form->getName())
                );

                $routeOptions = array(
                    'id' => $user->getId(),
                    '_format' => $request->get('_format')
                );

                return $this->routeRedirectView('api_user_get', $routeOptions, Codes::HTTP_CREATED);
            } else {
                $user = $service->put(
                    $user,
                    $request->request->get($form->getName())
                );

                return $this->view(null, Codes::HTTP_NO_CONTENT);
            }
        } catch (InvalidUserFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Builds the form to use to update an existing user.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="User API",
     *  statusCodes = {
     *   200 = "Returned when successful"
     *  },
     *  requirements={
     *  {
     *    "name"="id",
     *    "dataType"="integer",
     *    "requirement"="\d+",
     *    "description"="User id"
     *   }
     *  }
     * )
     *
     * @View(
     *  template="PeopleBundle:User:userEditForm.html.twig",
     *  templateVar = "form"
     * )
     *
     * @Get("/{id}/edit", name="edit", options={"method_prefix" = false})
     *
     * @return FormTypeInterface
     */
    public function editAction($id)
    {
        $user = $this->getService()->getOr404($id);
        return $this->createForm(new UserType(), $user, array(
            "action" => $this->generateUrl('api_user_put', array('id'=>$id, "access_token"=>$_GET["access_token"])),
            "method" => "PUT"
        ));
    }

    /**
     * Deletes a user depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="User API",
     *  statusCodes = {
     *   200 = "Returned when User has been successfully deleted.",
     *   404 = "Returned when user doesn't exist."
     *  },
     *  requirements={
     *   {
     *    "name"="id",
     *    "dataType"="integer",
     *    "requirement"="\d+",
     *    "description"="User id"
     *   }
     *  }
     * )
     *
     * @Delete("/{id}", name="delete", options={ "method_prefix" = false })
     *
     * @param $id
     */
    public function deleteAction($id)
    {
        $service = $this->getService();
        $user = $service->getOr404($id);
        if (isset($user)) {
            return $service->delete($user);
        }
    }

    /**
     * Returns the appropriate service to handle related entity.
     *
     * @return EntityServiceInterface
     */
    protected function getService()
    {
        return $this->container->get('people_bundle.service.user');
    }

}
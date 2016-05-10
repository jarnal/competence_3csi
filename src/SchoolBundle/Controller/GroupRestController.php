<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/05/2016
 * Time: 18:10
 */

namespace SchoolBundle\Controller;

use EvaluationBundle\Entity\Examen;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use GlobalBundle\Abstraction\EntityServiceInterface;
use PeopleBundle\Entity\User;
use SchoolBundle\Entity\Group;
use SkillBundle\Entity\Competence;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class GroupRestController extends FOSRestController
{

    /**
     * Returns all groups.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Groups API",
     *  output={
     *      "class"="SchoolBundle\Entity\Group",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "groups"
     *  }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/", name="get_all", options={ "method_prefix" = false })
     *
     * @return JsonResponse
     */
    public function getAllAction()
    {
        return array("groups"=>$this->getService()->getAll());
    }

    /**
     * Returns a group by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Group API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Group id"
     *      }
     *  },
     *  output={
     *      "class"="SchoolBundle\Entity\Group",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when group exists",
     *     404 = "Returned when the group is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return Group
     */
    public function getAction($id)
    {
        return $this->getService()->getOr404($id);
    }

    /**
     * Deletes a game depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Group API",
     *  statusCodes = {
     *      200 = "Returned when game has been successfully deleted.",
     *      404 = "Returned when game doesn't exist."
     *  },
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Group id"
     *      }
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
        $game = $service->getOr404($id);
        if ( isset($game) ) {
            return $service->delete($game);
        }
    }

    /**
     * Returns all examens for a given group.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Group API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Group id"
     *      }
     *  },
     *  output={
     *      "class"="SkillBundle\Entity\Competence",
     *      "collection"=true,
     *      "collectionName"="examens",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when group exists",
     *     404 = "Returned when the group is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}/examens", name="get_examens", options={ "method_prefix" = false })
     *
     * @return Examen
     */
    public function listExamensAction($id)
    {
        $this->getService()->getOr404($id);
        return $this->container->get('evaluation_bundle.service.examen')->findByGroupId($id);
    }

    /**
     * Returns all users for a given group.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Group API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Group id"
     *      }
     *  },
     *  output={
     *      "class"="SkillBundle\Entity\Competence",
     *      "collection"=true,
     *      "collectionName"="examens",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when group exists",
     *     404 = "Returned when the group is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}/users", name="get_users", options={ "method_prefix" = false })
     *
     * @return User
     */
    public function listUsersAction($id)
    {
        $this->getService()->getOr404($id);
        return $this->container->get('people_bundle.service.user')->findByGroupId($id);
    }

    /**
     * Returns the appropriate service to handle related entity.
     *
     * @return EntityServiceInterface
     */
    protected function getService()
    {
        return $this->container->get('school_bundle.service.group');
    }

}
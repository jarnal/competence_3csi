<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/05/2016
 * Time: 18:10
 */

namespace SchoolBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use GlobalBundle\Abstraction\EntityServiceInterface;
use SchoolBundle\Entity\Diplome;
use SkillBundle\Entity\Competence;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DiplomeRestController extends FOSRestController
{

    /**
     * Returns all diplomes.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Diplomes API",
     *  output={
     *      "class"="SchoolBundle\Entity\Diplome",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "diplomes"
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
        return array("diplomes"=>$this->getService()->getAll());
    }

    /**
     * Returns a diplome by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Diplome API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Diplome id"
     *      }
     *  },
     *  output={
     *      "class"="SchoolBundle\Entity\Diplome",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when diplome exists",
     *     404 = "Returned when the diplome is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return Diplome
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
     *  section="Game API",
     *  statusCodes = {
     *      200 = "Returned when game has been successfully deleted.",
     *      404 = "Returned when game doesn't exist."
     *  },
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Game id"
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
     * Returns the appropriate service to handle related entity.
     *
     * @return EntityServiceInterface
     */
    protected function getService()
    {
        return $this->container->get('school_bundle.service.diplome');
    }

}
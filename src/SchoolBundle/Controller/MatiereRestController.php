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
use SchoolBundle\Entity\Matiere;
use SkillBundle\Entity\Competence;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class MatiereRestController extends FOSRestController
{

    /**
     * Returns all matieres.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Matiere API",
     *  output={
     *      "class"="SchoolBundle\Entity\Matiere",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "matieres"
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
        return array("matieres"=>$this->getService()->getAll());
    }

    /**
     * Returns a matiere by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Matiere API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Matiere id"
     *      }
     *  },
     *  output={
     *      "class"="SchoolBundle\Entity\Matiere",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when matiere exists",
     *     404 = "Returned when the matiere is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return Matiere
     */
    public function getAction($id)
    {
        return $this->getService()->getOr404($id);
    }

    /**
     * Deletes a matiere depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Matiere API",
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
     * Returns all competences for a given matiere.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Matiere API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Matiere id"
     *      }
     *  },
     *  output={
     *      "class"="SkillBundle\Entity\Competence",
     *      "collection"=true,
     *      "collectionName"="competences",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when matiere exists",
     *     404 = "Returned when the matiere is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}/competences", name="get_competences", options={ "method_prefix" = false })
     *
     * @return Competence
     */
    public function listCompetencesAction($id)
    {
        $this->getService()->getOr404($id);
        return $this->container->get('skill_bundle.service.competence')->findByMatiereId($id);
    }

    /**
     * Returns the appropriate service to handle related entity.
     *
     * @return EntityServiceInterface
     */
    protected function getService()
    {
        return $this->container->get('school_bundle.service.matiere');
    }

}
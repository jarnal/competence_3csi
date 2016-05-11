<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/05/2016
 * Time: 18:10
 */

namespace EvaluationBundle\Controller;

use EvaluationBundle\Entity\TypeNote;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use GlobalBundle\Abstraction\EntityServiceInterface;
use SkillBundle\Entity\Competence;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class TypeNoteRestController extends FOSRestController
{

    /**
     * Returns all typenotes.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="TypeNotes API",
     *  output={
     *      "class"="SchoolBundle\Entity\TypeNote",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "type_notes"
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
        return array("type_notes"=>$this->getService()->getAll());
    }

    /**
     * Returns a typenote by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="TypeNote API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="TypeNote id"
     *      }
     *  },
     *  output={
     *      "class"="EvaluationBundle\Entity\TypeNote",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when typenote exists",
     *     404 = "Returned when the typenote is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return TypeNote
     */
    public function getAction($id)
    {
        return $this->getService()->getOr404($id);
    }

    /**
     * Returns the appropriate service to handle related entity.
     *
     * @return EntityServiceInterface
     */
    protected function getService()
    {
        return $this->container->get('evaluation_bundle.service.type_note');
    }

}
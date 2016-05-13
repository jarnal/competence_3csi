<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/05/2016
 * Time: 18:10
 */

namespace EvaluationBundle\Controller;

use EvaluationBundle\Entity\EvaluationExamen;
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

class EvaluationExamenRestController extends FOSRestController
{

    /**
     * Returns all evaluation examens.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="EvaluationExamen API",
     *  output={
     *      "class"="SchoolBundle\Entity\EvaluationExamen",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "evaluations_examen"
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
        return array("evaluations_examen"=>$this->getService()->getAll());
    }

    /**
     * Returns an evaluation examen by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="EvaluationExamen API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Evaluation Auto id"
     *      }
     *  },
     *  output={
     *      "class"="SchoolBundle\Entity\EvaluationExamen",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when evaluation examen exists",
     *     404 = "Returned when the evaluation examen is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return EvaluationExamen
     */
    public function getAction($id)
    {
        return $this->getService()->getOr404($id);
    }

    /**
     * @param $data
     */
    public function postAction($data)
    {

    }

    /**
     * Deletes an evaluation examen depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="EvaluationExamen API",
     *  statusCodes = {
     *      200 = "Returned when evaluation examen has been successfully deleted.",
     *      404 = "Returned when evaluation examen doesn't exist."
     *  },
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Evaluation Auto id"
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
        return $this->container->get('evaluation_bundle.service.evaluation_examen');
    }

}
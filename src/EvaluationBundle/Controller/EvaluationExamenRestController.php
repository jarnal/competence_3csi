<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/05/2016
 * Time: 18:10
 */

namespace EvaluationBundle\Controller;

use EvaluationBundle\Entity\EvaluationExamen;
use EvaluationBundle\Entity\EvaluationIntervenant;
use EvaluationBundle\Entity\Examen;
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

class EvaluationExamenRestController extends FOSRestController
{

    /**
     * Returns all evaluation examens.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Evaluation Examen API",
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
     *  section="Evaluation Examen API",
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
     * @return Examen
     */
    public function getAction($id)
    {
        return $this->getService()->getOr404($id);
    }

    /**
     * Adds a new user.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Evaluation Examen API",
     *  input="EvaluationBundle\Form\EvaluationIntervenantType",
     *  statusCodes = {
     *      200 = "Returned when the user has been created",
     *      400 = "Returned when the user form has errors"
     *  }
     * )
     *
     * @View(
     *  serializerGroups={"Default"},
     *  template="EvaluationBundle:EvaluationIntervenant:evaluatiojintervenantForm.html.twig",
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
        $competenceService = $this->container->get("skill_bundle.service.competence");
        $typeNoteService = $this->container->get("evaluation_bundle.service.type_note");
        $userService = $this->container->get("people_bundle.service.user");
        $examenService = $this->container->get("evaluation_bundle.service.examen");

        $noteLabel = $request->request->get("type_note_label");
        $noteValue = explode("-", $noteLabel)[0];
        $noteID = $typeNoteService->findOneByValue($noteValue);

        $evaluation = new EvaluationExamen();
        $evaluation->setExamen( $examenService->getOr404($request->request->get("examen_id")) );
        $evaluation->setCompetence( $competenceService->getOr404($request->request->get("competence_id")) );
        $evaluation->setIntervenant( $this->get('security.context')->getToken()->getUser() );
        $evaluation->setNote( $typeNoteService->getOr404($noteID) );
        $evaluation->setUser( $userService->getOr404($request->request->get("user_id")) );
        $evaluation->setEvaluatedAt( new \DateTime() );

        $this->getService()->save($evaluation);

        return $evaluation;
    }

    /**
     * Deletes an evaluation examen depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Evaluation Examen API",
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
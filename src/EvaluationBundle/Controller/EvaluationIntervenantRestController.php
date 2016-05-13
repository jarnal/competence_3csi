<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/05/2016
 * Time: 18:10
 */

namespace EvaluationBundle\Controller;

use EvaluationBundle\Entity\EvaluationIntervenant;
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

class EvaluationIntervenantRestController extends FOSRestController
{

    /**
     * Returns all evaluation intervenants.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="EvaluationIntervenant API",
     *  output={
     *      "class"="SchoolBundle\Entity\EvaluationIntervenant",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "evaluations_intervenant"
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
        return array("evaluations_intervenant"=>$this->getService()->getAll());
    }

    /**
     * Returns an evaluation intervenant by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="EvaluationIntervenant API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Evaluation Auto id"
     *      }
     *  },
     *  output={
     *      "class"="SchoolBundle\Entity\EvaluationIntervenant",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when evaluation intervenant exists",
     *     404 = "Returned when the evaluation intervenant is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return EvaluationIntervenant
     */
    public function getAction($id)
    {
        return $this->getService()->getOr404($id);
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
     *      template="EvaluationBundle:EvaluationBundle:evaluationintervenantForm.html.twig",
     *      templateVar = "form"
     * )
     *
     * @Get("/new", name="new", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface
     */
    public function newAction()
    {
        $evaluation = new EvaluationIntervenant();
        return $this->createForm(new EvaluationIntervenantType(), $evaluation, array(
            "action" => $this->generateUrl('api_evaluation_intervenant_new', array("access_token"=>$_GET["access_token"])),
            "method" => "POST"
        ));
    }

    /**
     * Adds a new user.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="User API",
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

        $noteLabel = $request->request->get("type_note_label");
        $noteValue = explode("-", $noteLabel)[0];
        $noteID = $typeNoteService->findOneByValue($noteValue);

        $evaluation = new EvaluationIntervenant();
        $evaluation->setCompetence( $competenceService->getOr404($request->request->get("competence_id")) );
        $evaluation->setIntervenant( $this->get('security.context')->getToken()->getUser() );
        $evaluation->setNote( $typeNoteService->getOr404($noteID) );
        $evaluation->setUser( $userService->getOr404($request->request->get("user_id")) );
        $evaluation->setEvaluatedAt( new \DateTime() );

        $this->getService()->save($evaluation);

        return $evaluation;
    }

    /**
     * Deletes an evaluation intervenant depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="EvaluationIntervenant API",
     *  statusCodes = {
     *      200 = "Returned when evaluation intervenant has been successfully deleted.",
     *      404 = "Returned when evaluation intervenant doesn't exist."
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
        return $this->container->get('evaluation_bundle.service.evaluation_intervenant');
    }

}
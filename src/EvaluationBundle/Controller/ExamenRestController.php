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
use SkillBundle\Entity\Competence;
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

class ExamenRestController extends FOSRestController
{

    /**
     * Returns all examens.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Examens API",
     *  output={
     *      "class"="SchoolBundle\Entity\Examen",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "examens"
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
        return array("examens"=>$this->getService()->getAll());
    }

    /**
     * Returns a examen by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Examen API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Examen id"
     *      }
     *  },
     *  output={
     *      "class"="SchoolBundle\Entity\Examen",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when examen exists",
     *     404 = "Returned when the examen is not found"
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
     *  section="Examen API",
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
        $groupService = $this->container->get("school_bundle.service.group");

        $examenName = $request->request->get("nom");
        $format = 'd/m/Y';
        $examenDate = \DateTime::createFromFormat($format, $request->request->get("date"));

        $examenDescription = $request->request->get("description");
        $intervenant = $this->get('security.context')->getToken()->getUser();
        $group = $groupService->getOr404($request->request->get("group_id"));

        $examen = new Examen();
        $examen->setName($examenName);
        $examen->setDescription($examenDescription);
        $examen->setIntervenant($intervenant);
        $examen->setGroup($group);
        $examen->setDate($examenDate);

        $competencesList = $request->request->get("competences");
        if( !is_array($competencesList) || count($competencesList) == 0 ) {
            return [
                "success"=>false,
                "error"=>"There must be at least one competence to create an examen."
            ];
        }

        //
        foreach($competencesList as $competence){
            $examen->addCompetence( $competenceService->getOr404($competence) );
        }

        $this->getService()->save($examen);

        return $examen;
    }

    /**
     * Returns all competences for a given examen.
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
     *      "collectionName"="competences",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when examen exists",
     *     404 = "Returned when the examen is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}/competences", name="get_competences", options={ "method_prefix" = false })
     *
     * @return Competence
     */
    public function listCompetencesAction($id){
        $this->getService()->getOr404($id);
        return $this->container->get('skill_bundle.service.competence')->findByExamenId($id);
    }

    /**
     * Deletes an examen depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Examen API",
     *  statusCodes = {
     *      200 = "Returned when examen has been successfully deleted.",
     *      404 = "Returned when examen doesn't exist."
     *  },
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Examen id"
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
        return $this->container->get('evaluation_bundle.service.examen');
    }

}
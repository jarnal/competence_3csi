<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 08/05/2016
 * Time: 18:10
 */

namespace SkillBundle\Controller;

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

class CompetenceRestController extends FOSRestController
{

    /**
     * Returns all competences.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Competence API",
     *  output={
     *      "class"="SchoolBundle\Entity\Competence",
     *      "collection"=true,
     *      "groups"={"Default"},
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser",
     *          "Nelmio\ApiDocBundle\Parser\CollectionParser"
     *      },
     *      "collectionName" = "competences"
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
        return array("competences"=>$this->getService()->getAll());
    }

    /**
     * Returns a competence by id.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Competence API",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Competence id"
     *      }
     *  },
     *  output={
     *      "class"="SchoolBundle\Entity\Competence",
     *      "parsers" = {
     *          "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *      },
     *      "groups"={"Default"}
     *  },
     *  statusCodes = {
     *     200 = "Returned when competence exists",
     *     404 = "Returned when the competence is not found"
     *   }
     * )
     *
     * @View( serializerGroups={"Default"} )
     *
     * @Get("/{id}", name="get", options={"method_prefix" = false}, requirements={"id"="\d+"})
     *
     * @return Competence
     */
    public function getAction($id)
    {
        return $this->getService()->getOr404($id);
    }

    /**
     * Adds a new competence.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Competence API",
     *  input="SchoolBundle\Form\GameType",
     *  statusCodes = {
     *      200 = "Returned when the game has been created",
     *      400 = "Returned when the game form has errors"
     *  }
     * )
     *
     * @View(
     *      serializerGroups={"Default"},
     *      template="TeamManagerTeamBundle:Team:gameForm.html.twig",
     *      statusCode= Codes::HTTP_BAD_REQUEST,
     *      templateVar = "form"
     * )
     *
     * @Post("/" , name="post", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface|View
     *
     */
    public function postAction(Request $request)
    {
        /*try {
            $form = new GameType();
            $game = $this->getService()->post(
                $request->request->get($form->getName()),
                $this->getUser()
            );

            $routeOptions = array(
                'id' => $game->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_game_get', $routeOptions, Codes::HTTP_CREATED);
        } catch (InvalidGameFormException $exception) {
            return $exception->getForm();
        }*/
    }

    /**
     * Builds the form to use to create a new competence.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Competence API",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the related team doesn't exist."
     *  },
     *  requirements={
     *      {
     *          "name"="teamID",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="The team to which the game will be related."
     *      }
     *  }
     * )
     *
     * @View(
     *      template="TeamManagerEventBundle:Game:gameForm.html.twig",
     *      templateVar = "form"
     * )
     *
     * @Get("/team/{teamID}/new", name="new", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface
     */
    public function newAction(Request $request, $teamID)
    {
        /*$team = $this->get('team_bundle.team.service')->getOr404($teamID);
        $game = new Game();
        $game->setTeam($team);
        $game->setSeason(CommonUtils::getCurrentSeason());

        return $this->createForm(
            new GameType(),
            $game,
            array(
                "action" => $this->generateUrl('api_game_post', array("access_token"=>$_GET["access_token"])),
                "method" => "POST"
            )
        );*/
    }

    /**
     * Update existing game from the submitted data or create a new competence.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Competence API",
     *  input="SchoolBundle\Form\GameType",
     *  statusCodes = {
     *      201 = "Returned when a new game is created",
     *      204 = "Returned when game has been updated successfully",
     *      400 = "Returned when the form has errors"
     *  },
     *  requirements= {
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="Game id"
     *       }
     *   }
     * )
     *
     * @View(
     *      serializerGroups={"Default"},
     * )
     *
     * @Put("/{id}", name="put", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface|View
     */
    public function putAction(Request $request, $id)
    {
        /*$service = $this->getService();
        try {
            $form = new GameType();
            if ( !($game = $service->get($id)) ) {
                $game = $service->post(
                    $request->request->get($form->getName())
                );

                $routeOptions = array(
                    'id' => $game->getId(),
                    '_format' => $request->get('_format')
                );

                return $this->routeRedirectView('api_game_get', $routeOptions, Codes::HTTP_CREATED);
            } else {
                $game = $service->put(
                    $game,
                    $request->request->get($form->getName())
                );

                return $this->view(null, Codes::HTTP_NO_CONTENT);
            }
        } catch (InvalidGameFormException $exception) {
            return $exception->getForm();
        }*/
    }

    /**
     * Builds the form to use to update an existing competence.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Competence API",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      404 = "Returned when the game doesn't exist."
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
     * @View(
     *      template="TeamManagerEventBundle:Game:gameEditForm.html.twig",
     *      templateVar = "form"
     * )
     *
     * @Get("/{id}/edit", name="edit", options={ "method_prefix" = false })
     *
     * @return FormTypeInterface
     */
    public function editAction($id)
    {
        /*$game = $this->getService()->getOr404($id);
        return $this->createForm(new GameType(), $game, array(
            "action" => $this->generateUrl('api_game_put',['id'=>$id, 'access_token'=>$_GET['access_token']]),
            "method" => "PUT"
        ));*/
    }

    /**
     * Deletes a competence depending on the passed id.
     *
     * @ApiDoc(
     *  resource = true,
     *  section="Competence API",
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
     * Returns all competence for a given intervenant.
     *
     * @ApiDoc(
     *  resource=true,
     *  section="Competence API",
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
    public function listByIntervenantAction($id)
    {
        //$this->getService()->getOr404($id);
        return $this->getService()->findMatieresByIntervenant($id);
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
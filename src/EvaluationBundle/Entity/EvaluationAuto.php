<?php

namespace EvaluationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use PeopleBundle\Entity\User;
use SkillBundle\Entity\Competence;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="c3csi_evaluation_auto")
 * @ORM\Entity(repositoryClass="EvaluationBundle\Repository\EvaluationAutoRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"auto" = "EvaluationAuto", "intervenant" = "EvaluationIntervenant", "examen" = "EvaluationExamen"})
 *
 * @ExclusionPolicy("all")
 */
class EvaluationAuto {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     * @Groups({"Global"})
     */
    private $id;

    /**
     * When the evaluation has been created
     *
     * @var \DateTime
     * @ORM\Column(name="evaluated_at", type="datetime")
     */
    protected $evaluated_at;

    /**
     * The user who has been evaluated
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="PeopleBundle\Entity\Usager")
     */
    protected $user;

    /**
     * The competence to wich the user has been evaluated
     *
     * @var Competence
     * @ORM\ManyToOne(targetEntity="SkillBundle\Entity\Competence")
     * @ORM\JoinColumn(name="competence_id", referencedColumnName="id")
     */
    protected $competence;

    /**
     * The note type attributes to the user
     *
     * @var TypeNote
     * @ORM\ManyToOne(targetEntity="EvaluationBundle\Entity\TypeNote")
     * @ORM\JoinColumn(name="note_id", referencedColumnName="id")
     */
    protected $note;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEvaluatedAt()
    {
        return $this->evaluated_at;
    }

    /**
     * @param mixed $evaluated_at
     */
    public function setEvaluatedAt($evaluated_at)
    {
        $this->evaluated_at = $evaluated_at;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * @param Competence $competence
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;
    }

    /**
     * @return TypeNote
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param TypeNote $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
}
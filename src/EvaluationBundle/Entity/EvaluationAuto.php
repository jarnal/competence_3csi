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
 * Diplome
 *
 * @ORM\Table(name="c3csi_evaluation_auto")
 * @ORM\Entity(repositoryClass="EvaluationBundle\Repository\TypeNoteRepository")
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
     * @ORM\Column(name="evaluated_at", type="datetime", nullable=true)
     */
    protected $evaluated_at;

    /**
     * The user who has been evaluated
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="PeopleBundle\Entity\User", inversedBy="evaluations")
     */
    protected $user;

    /**
     * The competence to wich the user has been evaluated
     *
     * @var Competence
     * @ORM\ManyToOne(targetEntity="SchoolBundle\Entity\Competence")
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

}
<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 05/05/2016
 * Time: 19:06
 */

namespace SchoolBundle\Entity;

use PeopleBundle\Entity\Intervenant;
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
 * EnseignementMatiere
 *
 * @ORM\Table(name="c3csi_enseignement")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\EnseignementRepository")
 *
 * @ExclusionPolicy("all")
 */
class Enseignement
{

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
     * Number of hours the matiere will be teached to the group
     *
     * @var integer
     * @ORM\Column(name="heures", type="integer")
     */
    private $heures;

    /**
     * Intervant who teaches the matiere
     *
     * @var Intervenant
     * @ORM\ManyToOne(targetEntity="PeopleBundle\Entity\Intervenant", inversedBy="enseignements")
     * @ORM\JoinColumn(name="intervenant_id", referencedColumnName="id", nullable=false)
     *
     * @Expose
     * @Groups({"Global"})
     */
    private $intervenant;

    /**
     * Matiere teached to the group
     *
     * @ORM\ManyToOne(targetEntity="SchoolBundle\Entity\Matiere")
     * @ORM\JoinColumn(name="matiere_id", referencedColumnName="id", nullable=false)
     *
     * @Expose
     * @Groups({"Global"})
     */
    private $matiere;

    /**
     * Group to which the matiere is teached
     *
     * @ORM\ManyToOne(targetEntity="SchoolBundle\Entity\Group", inversedBy="enseignements")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     *
     * @Expose
     * @Groups({"Global"})
     */
    private $group;

}
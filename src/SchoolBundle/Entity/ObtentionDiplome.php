<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 04/05/2016
 * Time: 13:31
 */

namespace SchoolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ObtentionDiplome
 *
 * @ORM\Table(name="c3csi_obtention_diplome")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\ObtentionDiplomeRepository")
 *
 * @ExclusionPolicy("all")
 */
class ObtentionDiplome
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
     * User who obtained the diplome
     *
     * @ORM\ManyToOne(targetEntity="PeopleBundle\Entity\User", inversedBy="diplomes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @Expose
     * @Groups({"Global"})
     */
    private $user;

    /**
     * Diplome entity
     *
     * @ORM\ManyToOne(targetEntity="SchoolBundle\Entity\Diplome")
     * @ORM\JoinColumn(name="diplome_id", referencedColumnName="id", nullable=false)
     *
     * @Expose
     * @Groups({"Global"})
     */
    private $diplome;

    /**
     * The date when the user has obtained his diplome
     *
     * @ORM\Column(name="date_obtention", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $date_obtention;

    /**
     * The mention obtained by the user on this diplome
     *
     * @ORM\Column(name="mention", type="string")
     * @var string
     */
    private $mention;

}
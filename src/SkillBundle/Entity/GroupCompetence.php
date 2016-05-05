<?php

namespace SkillBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Competence
 *
 * @ORM\Table(name="c3csi_group_competence")
 * @ORM\Entity(repositoryClass="SkillBundle\Repository\GroupCompetenceRepository")
 *
 * @ExclusionPolicy("all")
 */
class GroupCompetence
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
     * Name of the group of competence.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     *
     * @Groups({"Global"})
     * @Expose
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="SkillBundle\Entity\Competence")
     * @ORM\JoinTable(name="c3csi_groupcomp_rel_comp",
     *      joinColumns={@ORM\JoinColumn(name="groupcomp_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comp_id", referencedColumnName="id")}
     * )
     */
    private $competences;

    /**
     * GroupCompetence constructor.
     */
    public function __construct()
    {
        $this->competences = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get group competence name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set group competence name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}
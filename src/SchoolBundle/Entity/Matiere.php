<?php

namespace SchoolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use SkillBundle\Entity\Competence;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Group
 *
 * @ORM\Table(name="c3csi_matiere")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\MatiereRepository")
 *
 * @ExclusionPolicy("all")
 */
class Matiere {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     * @Groups({"Default"})
     */
    private $id;

    /**
     * Name of the matiere.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     *
     * @Groups({"Default"})
     * @Expose
     */
    private $name;

    /**
     * List of competences related to the matiere
     *
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="SkillBundle\Entity\Competence", inversedBy="matieres")
     * @ORM\JoinTable(name="c3csi_competence_rel_matiere",
     *      joinColumns={@ORM\JoinColumn(name="matiere_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="competence_id", referencedColumnName="id")}
     * )
     */
    private $competences;

    /**
     * Constructor.
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
     * Get competence name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set competence name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns complete competences list
     *
     * @return ArrayCollection
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Adds a competence to competences list
     *
     * @param Competence $competence
     */
    public function addCompetence(Competence $competence)
    {
        $this->competences[] = $competence;
    }

    /**
     * Removes a competence from competences list
     *
     * @param Competence $competence
     */
    public function removeUser(Competence $competence)
    {
        $this->competences->removeElement($competence);
    }

}
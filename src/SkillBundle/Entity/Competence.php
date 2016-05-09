<?php

namespace SkillBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use SchoolBundle\Entity\Matiere;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Competence
 *
 * @ORM\Table(name="c3csi_competence")
 * @ORM\Entity(repositoryClass="SkillBundle\Repository\CompetenceRepository")
 *
 * @ExclusionPolicy("all")
 */
class Competence
{

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
     * Name of the competence.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     *
     * @Groups({"Default"})
     * @Expose
     */
    private $name;

    /**
     * Contains all matieres that lists the competence
     *
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="SchoolBundle\Entity\Matiere", mappedBy="competences")
     */
    private $matieres;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->matieres = new ArrayCollection();
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
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Adds a matiere to matiere list
     *
     * @param Matiere $matiere
     */
    public function addMatiere(Matiere $matiere)
    {
        $this->matieres[] = $matiere;
    }

    /**
     * Removes a matiere from matieres list
     *
     * @param Matiere $matiere
     */
    public function removeMatiere(Matiere $matiere)
    {
        $this->matieres->removeElement($matiere);
    }

}
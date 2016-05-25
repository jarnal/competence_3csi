<?php

namespace EvaluationBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use PeopleBundle\Entity\Intervenant;
use PeopleBundle\Entity\User;
use SchoolBundle\Entity\Group;
use SkillBundle\Entity\Competence;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Diplome
 *
 * @ORM\Table(name="c3csi_examen")
 * @ORM\Entity(repositoryClass="EvaluationBundle\Repository\ExamenRepository")
 *
 * @ExclusionPolicy("all")
 */

class Examen {

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
     * Description of the examen.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     *
     * @Groups({"Default"})
     * @Expose
     */
    private $name;

    /**
     * Description of the examen.
     *
     * @var string
     * @ORM\Column(name="description", type="string")
     *
     * @Groups({"Default"})
     * @Expose
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime")
     *
     * @Groups({"Default"})
     * @Expose
     */
    private $date;

    /**
     *
     *
     * @var Intervenant
     * @ORM\ManyToOne(targetEntity="PeopleBundle\Entity\Intervenant", inversedBy="examens")
     */
    private $intervenant;

    /**
     *
     *
     * @var Group
     * @ORM\ManyToOne(targetEntity="SchoolBundle\Entity\Group", inversedBy="examens")
     */
    private $group;

    /**
     *
     *
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="SkillBundle\Entity\Competence")
     * @ORM\JoinTable(name="c3csi_examen_rel_competence",
     *      joinColumns={@ORM\JoinColumn(name="examen_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="competence_id", referencedColumnName="id")}
     *      )
     */
    private $competences;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->competences = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @VirtualProperty
     * @SerializedName("date")
     * @Groups({"Default"})
     */
    public function dateFormatted()
    {
        if(is_null($this->date)){
            return "";
        }
        $format = 'd/m/Y';
        return $this->date->format($format);
    }

    /**
     * @return mixed
     */
    public function getIntervenant()
    {
        return $this->intervenant;
    }

    /**
     * @param mixed $intervenant
     */
    public function setIntervenant($intervenant)
    {
        $this->intervenant = $intervenant;
    }

    /**
     * @return Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * @return ArrayCollection
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * @param Competence $competence
     */
    public function addCompetence(Competence $competence) {
        $this->competences[] = $competence;
    }

    /**
     * @param Competence $competence
     */
    public function removeCompetence(Competence $competence) {
        $this->competences->removeElement($competence);
    }

}
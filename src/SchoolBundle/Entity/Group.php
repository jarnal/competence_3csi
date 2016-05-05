<?php

namespace SchoolBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EvaluationBundle\Entity\Examen;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

use PeopleBundle\Entity\User;
use SchoolBundle\Entity\TypeGroup;

/**
 * Group
 *
 * @ORM\Table(name="c3csi_group")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\GroupRepository")
 *
 * @ExclusionPolicy("all")
 */
class Group {

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
     * Name of the group
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     *
     * @Groups({"Global"})
     * @Expose
     */
    private $name;

    /**
     * Period (year) of the group
     *
     * @var string
     * @ORM\Column(name="periode", type="string")
     *
     * @Groups({"Global"})
     * @Expose
     */
    private $periode;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolBundle\Entity\TypeGroup")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @var TypeGroup
     */
    private $type;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="PeopleBundle\Entity\User", inversedBy="groups")
     * @ORM\JoinTable(name="c3csi_group_rel_user",
     *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $users;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SchoolBundle\Entity\Enseignement", mappedBy="group")
     */
    private $enseignements;

    /**
     * @var Examen
     * @ORM\OneToMany(targetEntity="EvaluationBundle\Entity\Examen", mappedBy="group")
     */
    private $examens;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->enseignements = new ArrayCollection();
        $this->examens = new ArrayCollection();
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
     * Returns name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns periode
     *
     * @return string
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * Returns periode
     *
     * @param string $periode
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;
    }

    /**
     * Returns type
     *
     * @return \SchoolBundle\Entity\TypeGroup
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets type
     *
     * @param \SchoolBundle\Entity\TypeGroup $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns complete users list
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Adds a user to users list
     *
     * @param User $user
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Removes a user from users list
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

}
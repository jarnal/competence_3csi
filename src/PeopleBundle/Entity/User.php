<?php

namespace PeopleBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PeopleBundle\Abstraction\SpecificUserInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="c3csi_user")
 * @ORM\Entity(repositoryClass="PeopleBundle\Repository\UserRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "usager" = "Usager", "intervenant" = "Intervenant"})
 *
 * @ExclusionPolicy("all")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"UserAPIKey", "UserGlobal","UserDetails"})
     * @Expose
     */
    protected $id;

    /**
     * First name of the user.
     *
     * @var string
     * @ORM\Column(name="firstname", type="string")
     * @Assert\NotBlank( message="form.player.firstname.blank" )
     * @Assert\NotNull( message="form.player.firstname.null" )
     *
     * @Groups({"UserGlobal","UserDetails"})
     * @Expose
     */
    protected $firstname;

    /**
     * Last name of the user.
     *
     * @var string
     * @ORM\Column(name="lastname", type="string")
     *
     * @Groups({"UserGlobal","UserDetails"})
     * @Expose
     */
    protected $lastname;

    /**
     * Api key of the user.
     *
     * @var integer
     * @ORM\Column(name="api_key", type="string", nullable=true)
     *
     */
    protected $api_key;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->firstname = "";
        $this->lastname = "";
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get player first name.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set player first name.
     *
     * @param string $pFirstname
     * @return User
     */
    public function setFirstname($pFirstname)
    {
        $this->firstname = $pFirstname;
        return $this;
    }

    /**
     * Get player last name.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set player last name.
     *
     * @param string $pLastname
     * @return User
     */
    public function setLastname($pLastname)
    {
        $this->lastname = $pLastname;
        return $this;
    }

    /**
     * Set player api key.
     *
     * @param mixed $api_key
     */
    public function setApiKey($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Get player api key.
     *
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

}


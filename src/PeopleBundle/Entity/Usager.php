<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 06/05/2016
 * Time: 00:25
 */

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
 * @ORM\Entity(repositoryClass="PeopleBundle\Repository\UsagerRepository")
 */
class Usager extends User
{

    /**
     * List of all groups of the user
     *
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="SchoolBundle\Entity\Group", mappedBy="users")
     */
    protected $class_groups;

    /**
     * List of diplomes obtained by the user
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SchoolBundle\Entity\ObtentionDiplome", mappedBy="user")
     */
    protected $diplomes;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EvaluationBundle\Entity\EvaluationAuto", mappedBy="user")
     */
    protected $evaluations_auto;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EvaluationBundle\Entity\EvaluationIntervenant", mappedBy="user")
     */
    protected $evaluations_intervenant;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EvaluationBundle\Entity\EvaluationExamen", mappedBy="user")
     */
    protected $evaluations_examen;

    /**
     * @var ArrayCollection
     */
    protected $contacts;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->class_groups = new ArrayCollection();
        $this->diplomes = new ArrayCollection();

        $this->evaluations_auto = new ArrayCollection();
        $this->evaluations_examen = new ArrayCollection();
        $this->evaluations_intervenant = new ArrayCollection();

        $this->contacts = new ArrayCollection();
    }

}
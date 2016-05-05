<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 06/05/2016
 * Time: 00:24
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
 * @ORM\Entity(repositoryClass="PeopleBundle\Repository\IntervenantRepository")
 */
class Intervenant extends User
{

    /**
     *
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SchoolBundle\Entity\Enseignement", mappedBy="intervenant")
     */
    protected $enseignements;

    /**
     *
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EvaluationBundle\Entity\Examen", mappedBy="intervenant")
     */
    protected $examens;

    /**
     *
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EvaluationBundle\Entity\EvaluationIntervenant", mappedBy="intervenant")
     */
    protected $evaluations_intervenant;

    /**
     *
     *
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="EvaluationBundle\Entity\EvaluationExamen", mappedBy="intervenant")
     */
    protected $evaluations_examen;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->enseignements = new ArrayCollection();
        $this->examens = new ArrayCollection();
        $this->evaluations_examen = new ArrayCollection();
        $this->evaluations_intervenant = new ArrayCollection();
    }

}
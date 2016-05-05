<?php

namespace EvaluationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use PeopleBundle\Entity\Intervenant;
use PeopleBundle\Entity\User;
use SkillBundle\Entity\Competence;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EvaluationIntervenant
 *
 * @ORM\Entity(repositoryClass="EvaluationBundle\Repository\EvaluationIntervenantRepository")
 */
class EvaluationIntervenant extends EvaluationAuto {

    /**
     * Intervenant who attributed the evaluation
     *
     * @var Intervenant
     * @ORM\ManyToOne(targetEntity="PeopleBundle\Entity\Intervenant", inversedBy="evaluations")
     */
    protected $intervenant;

    /**
     * @return Intervenant
     */
    public function getIntervenant()
    {
        return $this->intervenant;
    }

    /**
     * @param Intervenant $intervenant
     */
    public function setIntervenant($intervenant)
    {
        $this->intervenant = $intervenant;
    }

}
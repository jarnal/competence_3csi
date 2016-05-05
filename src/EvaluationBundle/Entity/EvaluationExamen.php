<?php

namespace EvaluationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use PeopleBundle\Entity\User;
use SkillBundle\Entity\Competence;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EvaluationExamen
 *
 * @ORM\Entity(repositoryClass="EvaluationBundle\Repository\EvaluationExamenRepository")
 */
class EvaluationExamen extends EvaluationIntervenant {

    /**
     * Intervenant who attributed the evaluation
     *
     * @var Examen
     * @ORM\ManyToOne(targetEntity="EvaluationBundle\Entity\Examen", inversedBy="evaluations")
     */
    protected $examen;

    /**
     * @return Examen
     */
    public function getExamen()
    {
        return $this->examen;
    }

    /**
     * @param Examen $examen
     */
    public function setExamen($examen)
    {
        $this->examen = $examen;
    }

}
<?php

namespace EvaluationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Diplome
 *
 * @ORM\Table(name="c3csi_type_note")
 * @ORM\Entity(repositoryClass="EvaluationBundle\Repository\TypeNoteRepository")
 *
 * @ExclusionPolicy("all")
 */
class TypeNote {

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
     * Label of the type note
     *
     * @var string
     * @ORM\Column(name="label", type="string")
     */
    private $label;

    /**
     * Integer value of the type note
     *
     * @var integer
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns label
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets label
     *
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Returns integer value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Returns integer value
     *
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}
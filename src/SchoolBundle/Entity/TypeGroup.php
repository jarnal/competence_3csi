<?php

namespace SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Group
 *
 * @ORM\Table(name="c3csi_type_group")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\TypeGroupRepository")
 *
 * @ExclusionPolicy("all")
 */
class TypeGroup {

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
     * Name of the competence.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     *
     * @Groups({"Global"})
     * @Expose
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="SchoolBundle\Entity\Diplome")
     * @ORM\JoinColumn(name="diplome_id", referencedColumnName="id")
     * @var Diplome
     */
    private $diplome;

    /**
     * @return Diplome
     */
    public function getDiplome()
    {
        return $this->diplome;
    }

    /**
     * @param Diplome $diplome
     */
    public function setDiplome(Diplome $diplome)
    {
        $this->diplome = $diplome;
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

}
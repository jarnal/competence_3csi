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
 * Diplome
 *
 * @ORM\Table(name="c3csi_diplome")
 * @ORM\Entity(repositoryClass="SchoolBundle\Repository\DiplomeRepository")
 *
 * @ExclusionPolicy("all")
 */
class Diplome {

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
     * Description of the diplome.
     *
     * @var string
     * @ORM\Column(name="name", type="string")
     *
     * @Groups({"Global"})
     * @Expose
     */
    private $name;

    /**
     * Description of the diplome.
     *
     * @var string
     * @ORM\Column(name="description", type="string")
     *
     * @Groups({"Global"})
     * @Expose
     */
    private $description;

    /**
     * Returns id
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
     * Returns description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

}
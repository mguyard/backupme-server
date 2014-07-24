<?php

namespace BackupMe\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Module
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BackupMe\MainBundle\Entity\ModuleRepository")
 * @UniqueEntity(fields="name", message="Ce module existe existe déjà.")
 */
class Module
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du module doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du module ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="BackupMe\MainBundle\Entity\ModuleType", inversedBy="modules")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
    */
    private $moduletype;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IsBeta", type="boolean")
     * @Assert\Type(type="bool", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $isBeta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IsActive", type="boolean")
     * @Assert\Type(type="bool", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $isActive;


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
     * Set name
     *
     * @param string $name
     * @return Module
     */
    public function setName($name)
    {
        $this->name = strtoupper($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     * @return Module
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isBeta
     *
     * @param boolean $isBeta
     * @return Module
     */
    public function setIsBeta($isBeta)
    {
        $this->isBeta = $isBeta;

        return $this;
    }

    /**
     * Get isBeta
     *
     * @return boolean
     */
    public function getIsBeta()
    {
        return $this->isBeta;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Module
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set moduletype
     *
     * @param \BackupMe\MainBundle\Entity\ModuleType $moduletype
     * @return Module
     */
    public function setModuletype(\BackupMe\MainBundle\Entity\ModuleType $moduletype)
    {
        $this->moduletype = $moduletype;

        return $this;
    }

    /**
     * Get moduletype
     *
     * @return \BackupMe\MainBundle\Entity\ModuleType
     */
    public function getModuletype()
    {
        return $this->moduletype;
    }
}

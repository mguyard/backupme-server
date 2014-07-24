<?php

namespace BackupMe\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ModuleType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BackupMe\MainBundle\Entity\ModuleTypeRepository")
 * @UniqueEntity(fields="name", message="Ce type de module existe déjà.")
 */
class ModuleType
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
     *      minMessage = "Le type de module doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le type de module ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="BackupMe\MainBundle\Entity\Module", mappedBy="moduletype", cascade={"remove"})
    */
    private $modules;

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
     * @return ModuleType
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Constructor
     */
    public function __construct()
    {
        $this->modules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return ModuleType
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
     * Add modules
     *
     * @param \BackupMe\MainBundle\Entity\Module $modules
     * @return ModuleType
     */
    public function addModule(\BackupMe\MainBundle\Entity\Module $modules)
    {
        $this->modules[] = $modules;

        return $this;
    }

    /**
     * Remove modules
     *
     * @param \BackupMe\MainBundle\Entity\Module $modules
     */
    public function removeModule(\BackupMe\MainBundle\Entity\Module $modules)
    {
        $this->modules->removeElement($modules);
    }

    /**
     * Get modules
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModules()
    {
        return $this->modules;
    }
}

<?php

namespace BackupMe\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Location
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BackupMe\MainBundle\Entity\LocationRepository")
 * @UniqueEntity(fields={"name","contract"}, message="Ce site existe déjà pour ce contrat.")
 */
class Location
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du site doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du site ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $name;

    /**
    * @Gedmo\Slug(fields={"name"}, style="camel", unique=false)
    * @ORM\Column(name="SlugName", type="string", length=300)
    */
    private $slugName;

    /**
     * @ORM\ManyToOne(targetEntity="BackupMe\MainBundle\Entity\Contract", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
    */
    private $contract;

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
     * @return Location
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
     * Set slugName
     *
     * @param string $slugName
     * @return Location
     */
    public function setSlugName($slugName)
    {
        $this->slugName = $slugName;

        return $this;
    }

    /**
     * Get slugName
     *
     * @return string
     */
    public function getSlugName()
    {
        return $this->slugName;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Location
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
     * Set contract
     *
     * @param \BackupMe\MainBundle\Entity\Contract $contract
     * @return Location
     */
    public function setContract(\BackupMe\MainBundle\Entity\Contract $contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \BackupMe\MainBundle\Entity\Contract
     */
    public function getContract()
    {
        return $this->contract;
    }
}

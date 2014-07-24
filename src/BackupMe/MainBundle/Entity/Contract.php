<?php

namespace BackupMe\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Contract
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BackupMe\MainBundle\Entity\ContractRepository")
 * @UniqueEntity(fields={"name","company"}, message="Ce nom de contrat existe déjà pour ce client.")
 */
class Contract
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
     * @ORM\Column(name="Name", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom du contract doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du contract ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $name;

    /**
    * @Gedmo\Slug(fields={"name"})
    * @ORM\Column(name="SlugName", type="string", length=300)
    */
    private $slugName;

    /**
     * @ORM\ManyToOne(targetEntity="BackupMe\MainBundle\Entity\Company", inversedBy="contracts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
    */
    private $company;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IsActive", type="boolean")
     * @Assert\Type(type="bool", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
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
     * Set name
     *
     * @param string $name
     * @return Contract
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Contract
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
     * Set company
     *
     * @param \BackupMe\MainBundle\Entity\Company $company
     * @return Contract
     */
    public function setCompany(\BackupMe\MainBundle\Entity\Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \BackupMe\MainBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set slugName
     *
     * @param string $slugName
     * @return Contract
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
}

<?php

namespace BackupMe\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Company
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BackupMe\MainBundle\Entity\CompanyRepository")
 * @UniqueEntity(fields="longName", message="Cette société existe déjà.")
 * @UniqueEntity(fields="shortName", message="Ce trigramme existe déjà.")
 */
class Company
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
     * @ORM\Column(name="LongName", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @Assert\Length(
     *      min = "2",
     *      max = "255",
     *      minMessage = "Le nom de la société doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom de la société ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $longName;

    /**
     * @var string
     *
     * @ORM\Column(name="ShortName", type="string", length=6, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Type(type="string", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     * @Assert\Length(
     *      min = "3",
     *      max = "6",
     *      minMessage = "Le trigramme de la société doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le trigramme de la société ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $shortName;

    /**
     * @ORM\OneToMany(targetEntity="BackupMe\MainBundle\Entity\Contract", mappedBy="company", cascade={"remove"})
    */
    private $contracts;

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
     * Set longName
     *
     * @param string $longName
     * @return Company
     */
    public function setLongName($longName)
    {
        $this->longName = $longName;

        return $this;
    }

    /**
     * Get longName
     *
     * @return string
     */
    public function getLongName()
    {
        return $this->longName;
    }

    /**
     * Set shortName
     *
     * @param string $shortName
     * @return Company
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Company
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
     * Constructor
     */
    public function __construct()
    {
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
    }

    /**
     * Add contracts
     *
     * @param \BackupMe\MainBundle\Entity\Contract $contracts
     * @return Company
     */
    public function addContract(\BackupMe\MainBundle\Entity\Contract $contracts)
    {
        $this->contracts[] = $contracts;

        return $this;
    }

    /**
     * Remove contracts
     *
     * @param \BackupMe\MainBundle\Entity\Contract $contracts
     */
    public function removeContract(\BackupMe\MainBundle\Entity\Contract $contracts)
    {
        $this->contracts->removeElement($contracts);
    }

    /**
     * Get contracts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
        return $this->contracts;
    }
}

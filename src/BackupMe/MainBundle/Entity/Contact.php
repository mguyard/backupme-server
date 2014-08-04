<?php

namespace BackupMe\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BackupMe\MainBundle\Entity\ContactRepository")
 * @UniqueEntity(fields="email", message="Cette adresse email existe déjà.")
 */
class Contact
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
     *      minMessage = "Le nom du contact doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom du contact ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IsActive", type="boolean")
     * @Assert\Type(type="bool", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="BackupMe\MainBundle\Entity\ApiClient", mappedBy="contacts", cascade={"persist"})
    */
    private $ApiClients;


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
     * @return Contact
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
     * Set email
     *
     * @param string $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Contact
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
        $this->ApiClients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
    }

    public function __toString()
    {
        return $this->getName()." (".$this->getEmail().")";
    }

    /**
     * Add ApiClients
     *
     * @param \BackupMe\MainBundle\Entity\ApiClient $apiClients
     * @return Contact
     */
    public function addApiClient(\BackupMe\MainBundle\Entity\ApiClient $apiClients)
    {
        $this->ApiClients[] = $apiClients;

        return $this;
    }

    /**
     * Remove ApiClients
     *
     * @param \BackupMe\MainBundle\Entity\ApiClient $apiClients
     */
    public function removeApiClient(\BackupMe\MainBundle\Entity\ApiClient $apiClients)
    {
        $this->ApiClients->removeElement($apiClients);
    }

    /**
     * Get ApiClients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApiClients()
    {
        return $this->ApiClients;
    }
}

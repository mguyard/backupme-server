<?php

namespace BackupMe\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * ApiClient
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="BackupMe\MainBundle\Entity\ApiClientRepository")
 * @UniqueEntity(fields="name", message="Ce nom existe déjà.")
 * @UniqueEntity(fields="iPAddress", message="Cette adresse IP est déjà déclaré.")
 */
class ApiClient
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
     *      min = "3",
     *      max = "255",
     *      minMessage = "Le nom FQDN doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom FQDN ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @Assert\Regex(
     *     pattern = "/(?=^.{1,254}$)(^(((?!-)[a-zA-Z0-9-]{1,63}(?<!-))|((?!-)[a-zA-Z0-9-]{1,63}(?<!-)\.)+[a-zA-Z]{2,63})$)/",
     *     match = true,
     *     message = "Le nom FQDN n'est pas valide"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="IPAdress", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Ip(
     *      version = "all",
     *      message = "La valeur {{ value }} n'est pas une adresse IPv4 ou IPv6 valide"
     * )
     */
    private $iPAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut être vide.")
     * @Assert\Choice(
     *      choices = {"internal", "external"},
     *      message = "La valeur {{ value }} n'est pas un ApiClientType valide.")
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="IsActive", type="boolean")
     * @Assert\Type(type="bool", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $isActive;

    /**
     * Constructor
     */
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return ApiClient
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
     * Set type
     *
     * @param string $type
     * @return ApiClient
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ApiClient
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
     * Set iPAddress
     *
     * @param string $iPAddress
     * @return ApiClient
     */
    public function setIPAddress($iPAddress)
    {
        $this->iPAddress = $iPAddress;

        return $this;
    }

    /**
     * Get iPAddress
     *
     * @return string
     */
    public function getIPAddress()
    {
        return $this->iPAddress;
    }
}

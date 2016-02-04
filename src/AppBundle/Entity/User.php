<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use Gedmo\Timestampable\Traits\Timestampable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="ft_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("facebookId")
 */
class User
{
    use Timestampable;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="facebook_id", type="string", length=255, unique=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Collection|Visit[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Visit", mappedBy="searcher", cascade={"persist", "remove"}, fetch="EAGER", orphanRemoval=true)
     */
    private $asSearcherVisits;


    /**
     * @var Collection|Visit[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Visit", mappedBy="tracker", cascade={"persist", "remove"}, fetch="EAGER", orphanRemoval=false)
     */
    private $asTrackerVisits;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Constructor
     */
    public function __construct()
    {
        $this->asSearcherVisits = new ArrayCollection();
        $this->asTrackerVisits = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Add asSearcherVisit
     *
     * @param Visit $asSearcherVisit
     *
     * @return User
     */
    public function addAsSearcherVisit(Visit $asSearcherVisit)
    {
        $this->asSearcherVisits[] = $asSearcherVisit;
        $asSearcherVisit->setSearcher($this);

        return $this;
    }

    /**
     * Remove asSearcherVisit
     *
     * @param \AppBundle\Entity\Visit $asSearcherVisit
     */
    public function removeAsSearcherVisit(Visit $asSearcherVisit)
    {
        $this->asSearcherVisits->removeElement($asSearcherVisit);
        $asSearcherVisit->setSearcher(null);
    }

    /**
     * Get asSearcherVisits
     *
     * @return Collection
     */
    public function getAsSearcherVisits()
    {
        return $this->asSearcherVisits;
    }

    /**
     * @return int
     */
    public function getNbAsSearcherVisits()
    {
        return $this->asSearcherVisits->count();
    }

    /**
     * Add asTrackerVisit
     *
     * @param Visit $asTrackerVisit
     *
     * @return User
     */
    public function addAsTrackerVisit(Visit $asTrackerVisit)
    {
        $this->asTrackerVisits[] = $asTrackerVisit;
        $asTrackerVisit->setTracker($this);

        return $this;
    }

    /**
     * Remove asTrackerVisit
     *
     * @param Visit $asTrackerVisit
     */
    public function removeAsTrackerVisit(Visit $asTrackerVisit)
    {
        $this->asTrackerVisits->removeElement($asTrackerVisit);
        $asTrackerVisit->setTracker(null);
    }

    /**
     * Get asTrackerVisits
     *
     * @return Collection
     */
    public function getAsTrackerVisits()
    {
        return $this->asTrackerVisits;
    }

    /**
     * @return int
     */
    public function getNbAsTrackerVisits()
    {
        return $this->asTrackerVisits->count();
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }
}

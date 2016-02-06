<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Visit
 *
 * @ORM\Table(name="ft_visit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Visit
{
    use TimestampableEntity;

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Url()
     * @ORM\Column(name="url", type="string", length=511)
     * @Serializer\Expose()
     */
    private $url;

    /**
     * Searcher
     *
     * @var User
     *
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", fetch="EAGER", inversedBy="asSearcherVisits")
     */
    private $searcher;

    /**
     * Tracker
     *
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", fetch="EAGER", inversedBy="asTrackerVisits")
     */
    private $tracker;

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->url);
    }

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
     * Set url
     *
     * @param string $url
     * @return Visit
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set searcher
     *
     * @param User $searcher
     *
     * @return Visit
     */
    public function setSearcher(User $searcher = null)
    {
        $this->searcher = $searcher;

        return $this;
    }

    /**
     * Get searcher
     *
     * @return User
     */
    public function getSearcher()
    {
        return $this->searcher;
    }

    /**
     * Set tracker
     *
     * @param User $tracker
     *
     * @return Visit
     */
    public function setTracker(User $tracker = null)
    {
        $this->tracker = $tracker;

        return $this;
    }

    /**
     * Get tracker
     *
     * @return User
     */
    public function getTracker()
    {
        return $this->tracker;
    }

    /**
     * @TODO: use serialization group instead
     *
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName(value="tracker")
     *
     * @return array|null
     */
    public function getTrackerData()
    {
        if (!$this->tracker) {
            return null;
        }

        return [
            'id' => $this->tracker->getId(),
            'name' => $this->tracker->getName(),
            'pictureUrl' => $this->searcher->getFacebookPictureUrl(),
        ];
    }
    /**
     * @TODO: use serialization group instead
     *
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName(value="searcher")
     *
     * @return array|null
     */
    public function getSearcherData()
    {
        if (!$this->searcher) {
            return null;
        }

        return [
            'id' => $this->searcher->getId(),
            'name' => $this->searcher->getName(),
            'pictureUrl' => $this->searcher->getFacebookPictureUrl(),
        ];
    }
}

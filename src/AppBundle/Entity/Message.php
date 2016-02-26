<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;


/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Message
{
    use TimestampableEntity;

    /**
     * @var int
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
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @ORM\Column(name="content", type="text")
     * @Serializer\Expose()
     */
    private $content;

    /**
     * Visit
     *
     * @var Visit
     *
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Visit", fetch="EAGER", inversedBy="messages")
     * @Serializer\Expose()
     */
    private $visit;

    /**
     * Author
     *
     * @var User
     *
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", fetch="EAGER", inversedBy="messages")
     */
    private $author;

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('Message %s', $this->id);
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
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Message
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set visit
     *
     * @param Visit $visit
     *
     * @return Message
     */
    public function setVisit(Visit $visit = null)
    {
        $this->visit = $visit;

        return $this;
    }

    /**
     * Get visit
     *
     * @return Visit
     */
    public function getVisit()
    {
        return $this->visit;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName(value="author")
     *
     * @return array|null
     */
    public function getSearcherData()
    {
        if (!$this->author) {
            return null;
        }

        if ($this->visit->getSearcher()->getId() === $this->author->getId()) {
            $role = 'searcher';
        } else {
            $role = 'tracker';
        }

        return [
            'id' => $this->author->getId(),
            'name' => $this->author->getName(),
            'pictureUrl' => $this->author->getFacebookPictureUrl(),
            'role'  => $role,
        ];
    }
}

<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */
class Post implements PostInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    protected $privacy;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    protected $state;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritDoc}
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }

    /**
     * {@inheritDoc}
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritDoc}
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public static function getStates()
    {
        return array(
            self::STATE_ACTIVE   => 'Active',
            self::STATE_DISABLED => 'Disabled',
        );
    }

    /**
     * {@inheritDoc}
     */
    public static function getPrivacies()
    {
        return array(
            self::PRIVACY_PUBLIC  => 'Public',
            self::PRIVACY_FRIENDS => 'Friends',
            self::PRIVACY_PRIVATE => 'Private',
        );
    }
}

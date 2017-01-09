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
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \CoreBundle\Entity\UserInterface
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    protected $privacy;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    protected $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\PostComment", mappedBy="respondent")
     */
    protected $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\PostComment", mappedBy="respondent")
     */
    protected $reactions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

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
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * {@inheritDoc}
     */
    public function addComments(array $comments)
    {
        /** @var \CoreBundle\Entity\PostCommentInterface $c */
        foreach ($comments as $c) {
            $this->addComment($c);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeComments(array $comments)
    {
        /** @var \CoreBundle\Entity\PostCommentInterface $c */
        foreach ($comments as $c) {
            $this->removeComment($c);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addComment(PostCommentInterface $comment)
    {
        $this->comments->add($comment);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeComment(PostCommentInterface $comment)
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getReactions()
    {
        return $this->reactions;
    }

    /**
     * {@inheritDoc}
     */
    public function addReactions(array $reactions)
    {
        /** @var \CoreBundle\Entity\PostReactionInterface $r */
        foreach ($reactions as $r) {
            $this->addReaction($r);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeReactions(array $reactions)
    {
        /** @var \CoreBundle\Entity\PostReactionInterface $r */
        foreach ($reactions as $r) {
            $this->removeReaction($r);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addReaction(PostReactionInterface $reaction)
    {
        $this->reactions->add($reaction);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeReaction(PostReactionInterface $reaction)
    {
        $this->reactions->removeElement($reaction);

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

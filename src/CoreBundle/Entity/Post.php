<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\PostRepository")
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
     *
     * @JMS\Type("integer")
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
     *
     * @Assert\NotBlank(groups = {"create"})
     * @Assert\Type("text", groups = {"create"})
     */
    protected $content;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @Assert\Choice(choices = "getTypes", groups = {"create"})
     * @Assert\Type("integer", groups = {"create"})
     */
    protected $type;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @Assert\Choice(choices = "getPrivacies", groups = {"create"})
     * @Assert\Type("integer", groups = {"create"})
     */
    protected $privacy;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @Assert\Choice(choices = "getStates", groups = {"create"})
     * @Assert\Type("integer", groups = {"create"})
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
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\PostComment", mappedBy="post", cascade={"persist"})
     */
    protected $comments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\PostReaction", mappedBy="post", cascade={"persist"})
     */
    protected $reactions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->type    = self::TYPE_POST;
        $this->privacy = self::PRIVACY_PUBLIC;
        $this->state   = self::STATE_ACTIVE;

        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();

        $this->comments  = new ArrayCollection();
        $this->reactions = new ArrayCollection();
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeLabel()
    {
        return self::getTypes()[$this->getType()];
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
    public function getPrivacyLabel()
    {
        return self::getPrivacies()[$this->getPrivacy()];
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
    public function getStateLabel()
    {
        return self::getStates()[$this->getState()];
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
    public function hasReaction(UserInterface $user)
    {
        /** @var \CoreBundle\Entity\PostReactionInterface $r */
        foreach ($this->getReactions() as $r) {
            if ($user->isEqual($r->getRespondent())) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_POST  => 'Post',
            self::TYPE_IMAGE => 'External Image',
            self::TYPE_VIDEO => 'Youtube Video',
        );
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
    public function isAllowed(UserInterface $user)
    {
        $owner = $this->getUser();

        if ($user->isEqual($owner)) {
            return true;
        }

        $privacies = array(
            self::PRIVACY_PUBLIC,
            self::PRIVACY_FRIENDS,
        );

        return ($owner->isFriend($user) && in_array($this->getPrivacy(), $privacies));
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

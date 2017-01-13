<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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
     * @Assert\NotBlank(groups = {"create", "edit"})
     * @Assert\Type("string", groups = {"create", "edit"})
     */
    protected $content;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @Assert\Choice(callback = "getTypes", groups = {"create", "edit"})
     * @Assert\Type("integer", groups = {"create", "edit"})
     */
    protected $type;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @Assert\Choice(callback = "getPrivacies", groups = {"create", "edit"})
     * @Assert\Type("integer", groups = {"create", "edit"})
     */
    protected $privacy;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @Assert\Choice(callback = "getStates", groups = {"admin_review"})
     * @Assert\Type("integer", groups = {"admin_review"})
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
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\User")
     * @ORM\JoinTable(name="post_reactions",
     *     joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
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
        $types = array_flip(self::getTypes());
        return $types[$this->getType()];
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
        $privacies = array_flip(self::getPrivacies());
        return $privacies[$this->getPrivacy()];
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
        $states = array_flip(self::getStates());
        return $states[$this->getState()];
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
        $comment->setPost($this);

        $this->comments->add($comment);

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
    public function addReaction(UserInterface $user)
    {
        $this->reactions->add($user);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeReaction(UserInterface $user)
    {
        $this->reactions->removeElement($user);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasReaction(UserInterface $user)
    {
        return $this->reactions->contains($user);
    }

    /**
     * {@inheritDoc}
     */
    public function isAuthor(UserInterface $user)
    {
        return (strcmp($this->getUser()->getId(), $user->getId()) === 0);
    }

    /**
     * {@inheritDoc}
     */
    public static function getTypes()
    {
        return array(
            'Post'           => self::TYPE_POST,
            'External Image' => self::TYPE_IMAGE,
            'Youtube Video'  => self::TYPE_YOUTUBE,
        );
    }

    /**
     * {@inheritDoc}
     */
    public static function getPrivacies()
    {
        return array(
            'Public'  => self::PRIVACY_PUBLIC,
            'Friends' => self::PRIVACY_FRIENDS,
            'Private' => self::PRIVACY_PRIVATE,
        );
    }

    /**
     * {@inheritDoc}
     */
    public static function getStates()
    {
        return array(
            'Active'   => self::STATE_ACTIVE,
            'Disabled' => self::STATE_DISABLED,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function isAllowed(UserInterface $user)
    {
        if ($user->isEqual($this->getUser())) {
            return true;
        }

        $privacies = array(
            self::PRIVACY_PUBLIC,
            self::PRIVACY_FRIENDS,
        );

        return ($this->getUser()->isFriend($user) && in_array($this->getPrivacy(), $privacies));
    }
}

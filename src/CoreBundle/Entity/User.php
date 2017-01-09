<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements UserInterface, \Serializable
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
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var string
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

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
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\User", inversedBy="friendsBy")
     * @ORM\JoinTable(
     *     name="user_friends",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="friend_id", referencedColumnName="id")}
     * )
     **/
    private $friends;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\User", mappedBy="friends")
     **/
    private $friendsBy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Post", mappedBy="user")
     */
    protected $posts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\PostComment", mappedBy="respondent")
     */
    protected $postComments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\PostReaction", mappedBy="respondent")
     */
    protected $postReactions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->friends = new ArrayCollection();
        $this->friendsBy = new ArrayCollection();
        $this->posts = new ArrayCollection();
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * {@inheritDoc}
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;

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
        return $this->createdAt;
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
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * {@inheritDoc}
     */
    public function addFriends(array $friends)
    {
        /** @var \CoreBundle\Entity\UserInterface $f */
        foreach ($friends as $f) {
            $this->addFriend($f);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeFriends(array $friends)
    {
        /** @var \CoreBundle\Entity\UserInterface $f */
        foreach ($friends as $f) {
            $this->removeFriend($f);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addFriend(UserInterface $friend)
    {
        $this->friends->add($friend);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeFriend(UserInterface $friend)
    {
        $this->friends->removeElement($friend);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFriendsBy()
    {
        return $this->friendsBy;
    }

    /**
     * {@inheritDoc}
     */
    public function getPeople()
    {
        return array_merge($this->getFriends()->toArray(), $this->getFriendsBy()->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * {@inheritDoc}
     */
    public function addPosts(array $posts)
    {
        /** @var \CoreBundle\Entity\PostInterface $p */
        foreach ($posts as $p) {
            $this->addPost($p);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removePosts(array $posts)
    {
        /** @var \CoreBundle\Entity\PostInterface $p */
        foreach ($posts as $p) {
            $this->removePost($p);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addPost(PostInterface $post)
    {
        $this->posts->add($post);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removePost(PostInterface $post)
    {
        $this->posts->removeElement($post);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function equals($user)
    {
        if ($user instanceof UserInterface) {
            return (strcmp($this->getId(), $user->getId()) === 0);
        }
        else if (is_string($user)) {
            return (strcmp($this->getUsername(), $user) === 0);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public static function getStates()
    {
        return array(
            self::STATE_PENDING  => 'Pending',
            self::STATE_ACTIVE   => 'Active',
            self::STATE_DISABLED => 'Disabled',
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isEnabled()
    {
        return $this->state == self::STATE_ACTIVE;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->name,
            $this->state,
            $this->createdAt,
            $this->updatedAt,
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->name,
            $this->state,
            $this->createdAt,
            $this->updatedAt,
            ) = unserialize($serialized);
    }
}

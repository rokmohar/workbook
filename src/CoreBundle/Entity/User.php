<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Orx;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 * @UniqueEntity("email", groups = {"register"})
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
     *
     * @Assert\Email(groups = {"register"})
     * @Assert\NotBlank(groups = {"register"})
     * @Assert\Type("string", groups = {"register"})
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
     *
     * @Assert\Length(min = 6, max = 255, groups = {"register"})
     * @Assert\NotBlank(groups = {"register"})
     * @Assert\Type("string", groups = {"register"})
     */
    protected $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\Length(min = 6, max = 255, groups = {"register"})
     * @Assert\NotBlank(groups = {"register"})
     * @Assert\Type("string", groups = {"register"})
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\Length(min = 20, max = 1000, groups = {})
     * @Assert\Type("text", groups = {})
     */
    protected $about;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(min = 6, max = 255, groups = {})
     * @Assert\Type("string", groups = {})
     */
    protected $avatar;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"unsigned"=true})
     *
     * @Assert\Choice(choices = "getTypes", groups = {})
     * @Assert\Type("integer", groups = {})
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
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\User", mappedBy="friends", cascade={"persist"})
     **/
    private $friendsBy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Post", mappedBy="user", cascade={"persist"})
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $posts;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->state = self::STATE_PENDING;

        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();

        $this->friends   = new ArrayCollection();
        $this->friendsBy = new ArrayCollection();
        $this->posts     = new ArrayCollection();
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
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * {@inheritDoc}
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * {@inheritDoc}
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

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
    public function getStateLabel()
    {
        return self::getStates()[$this->getType()];
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
        return new ArrayCollection(array_merge(
            $this->friends->toArray(),
            $this->friendsBy->toArray()
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function isFriend(UserInterface $person)
    {
        return ($this->getFriends()->contains($person));
    }

    /**
     * {@inheritDoc}
     */
    public function addFriend(UserInterface $person)
    {
        if (strcmp($this->getId(), $person->getId()) < 0) {
            return $person->addFriend($this);
        }

        $this->friends->add($person);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeFriend(UserInterface $person)
    {
        $this->friends->removeElement($person);
        $this->friendsBy->removeElement($person);

        return $this;
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
    public function addPost(PostInterface $post)
    {
        $post->setUser($this);
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
    public function isEqual(UserInterface $user)
    {
        return (strcmp($this->getId(), $user->getId()) === 0);
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

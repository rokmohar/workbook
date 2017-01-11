<?php

namespace CoreBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;

interface UserInterface extends \Symfony\Component\Security\Core\User\UserInterface, AdvancedUserInterface
{
    const STATE_PENDING  = 0;
    const STATE_ACTIVE   = 5;
    const STATE_DISABLED = 10;

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     */
    public function setId($id);

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getPlainPassword();

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getAbout();

    /**
     * @param string $about
     */
    public function setAbout($about);

    /**
     * @return string
     */
    public function getAvatar();

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar);

    /**
     * @return integer
     */
    public function getState();

    /**
     * @param integer $state
     */
    public function setState($state);

    /**
     * @return string
     */
    public function getStateLabel();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends();

    /**
     * @param \CoreBundle\Entity\UserInterface $person
     *
     * @return boolean
     */
    public function isFriend(UserInterface $person);

    /**
     * @param \CoreBundle\Entity\UserInterface $person
     */
    public function addFriend(UserInterface $person);

    /**
     * @param \CoreBundle\Entity\UserInterface $person
     */
    public function removeFriend(UserInterface $person);

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts();

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function addPost(PostInterface $post);

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function removePost(PostInterface $post);

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     *
     * @return boolean
     */
    public function isEqual(UserInterface $user);

    /**
     * @return array
     */
    public static function getStates();
}
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
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return integer
     */
    public function getState();

    /**
     * @param integer $state
     */
    public function setState($state);

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
    public function getPosts();

    /**
     * @param array $posts
     */
    public function addPosts(array $posts);

    /**
     * @param array $posts
     */
    public function removePosts(array $posts);

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function addPost(PostInterface $post);

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function removePost(PostInterface $post);

    /**
     * @return array
     */
    public static function getStates();
}
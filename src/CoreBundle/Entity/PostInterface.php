<?php

namespace CoreBundle\Entity;

interface PostInterface
{
    const TYPE_POST  = 0;
    const TYPE_IMAGE = 5;
    const TYPE_VIDEO = 10;

    const PRIVACY_PUBLIC  = 0;
    const PRIVACY_FRIENDS = 5;
    const PRIVACY_PRIVATE = 10;

    const STATE_ACTIVE   = 0;
    const STATE_DISABLED = 5;

    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     */
    public function setId($id);

    /**
     * @return \CoreBundle\Entity\UserInterface
     */
    public function getUser();

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function setUser(UserInterface $user);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param string $content
     */
    public function setContent($content);

    /**
     * @return integer
     */
    public function getType();

    /**
     * @param integer $type
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getTypeLabel();

    /**
     * @return integer
     */
    public function getPrivacy();

    /**
     * @param integer $privacy
     */
    public function setPrivacy($privacy);

    /**
     * @return string
     */
    public function getPrivacyLabel();

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
    public function getComments();

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     */
    public function addComment(PostCommentInterface $comment);

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReactions();

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function addReaction(UserInterface $user);

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function removeReaction(UserInterface $user);

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     *
     * @return boolean
     */
    public function hasReaction(UserInterface $user);

    /**
     * @return array
     */
    public static function getTypes();

    /**
     * @return array
     */
    public static function getStates();

    /**
     * @return array
     */
    public static function getPrivacies();
}

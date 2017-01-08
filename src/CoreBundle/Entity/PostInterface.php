<?php

namespace CoreBundle\Entity;

interface PostInterface
{
    const STATE_ACTIVE   = 0;
    const STATE_DISABLED = 5;

    const PRIVACY_PUBLIC  = 0;
    const PRIVACY_FRIENDS = 5;
    const PRIVACY_PRIVATE = 10;

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
    public function getPrivacy();

    /**
     * @param integer $privacy
     */
    public function setPrivacy($privacy);

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
     * @return array
     */
    public static function getStates();

    /**
     * @return array
     */
    public static function getPrivacies();
}

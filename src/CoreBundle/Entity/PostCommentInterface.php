<?php

namespace CoreBundle\Entity;

interface PostCommentInterface
{
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
     * @return \CoreBundle\Entity\PostInterface
     */
    public function getPost();

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function setPost(PostInterface $post);

    /**
     * @return \CoreBundle\Entity\UserInterface
     */
    public function getRespondent();

    /**
     * @param \CoreBundle\Entity\UserInterface $comment
     */
    public function setRespondent(UserInterface $comment);

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
     * @return array
     */
    public static function getStates();
}

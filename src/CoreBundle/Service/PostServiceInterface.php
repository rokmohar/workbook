<?php

namespace CoreBundle\Service;

use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\UserInterface;

interface PostServiceInterface
{
    /**
     * @param \CoreBundle\Entity\PostInterface $post
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function createPost(PostInterface $post, UserInterface $user);

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function updatePost(PostInterface $post);

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function deletePost(PostInterface $post);

    /**
     * @return \CoreBundle\Doctrine\PostManagerInterface
     */
    public function getPostManager();
}

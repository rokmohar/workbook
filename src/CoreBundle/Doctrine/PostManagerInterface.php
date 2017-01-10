<?php

namespace CoreBundle\Doctrine;

use CoreBundle\Entity\PostInterface;

interface PostManagerInterface
{
    /**
     * @return \CoreBundle\Entity\PostInterface
     */
    public function createPost();

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function updatePost(PostInterface $post);

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    public function deletePost(PostInterface $post);

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getObjectManager();

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    public function getObjectRepository();

    /**
     * @return string
     */
    public function getClassName();
}

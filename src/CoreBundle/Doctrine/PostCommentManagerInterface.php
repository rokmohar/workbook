<?php

namespace CoreBundle\Doctrine;

use CoreBundle\Entity\PostCommentInterface;

interface PostCommentManagerInterface
{
    /**
     * @return \CoreBundle\Entity\PostCommentInterface
     */
    public function createComment();

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     */
    public function updateComment(PostCommentInterface $comment);

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     */
    public function deleteComment(PostCommentInterface $comment);

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

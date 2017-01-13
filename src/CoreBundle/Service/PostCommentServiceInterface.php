<?php

namespace CoreBundle\Service;

use CoreBundle\Entity\PostCommentInterface;
use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\UserInterface;

interface PostCommentServiceInterface
{
    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     * @param \CoreBundle\Entity\PostInterface $post
     * @param \CoreBundle\Entity\UserInterface $respondent
     */
    public function createComment(PostCommentInterface $comment, PostInterface $post, UserInterface $respondent);

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     */
    public function updateComment(PostCommentInterface $comment);

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     */
    public function deleteComment(PostCommentInterface $comment);

    /**
     * @return \CoreBundle\Doctrine\CommentManagerInterface
     */
    public function getCommentManager();
}

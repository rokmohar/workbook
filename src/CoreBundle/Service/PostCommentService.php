<?php

namespace CoreBundle\Service;

use CoreBundle\Doctrine\PostCommentManagerInterface;
use CoreBundle\Entity\PostCommentInterface;
use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\UserInterface;
use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class PostCommentService implements PostCommentServiceInterface
{
    /**
     * @var \CoreBundle\Doctrine\PostCommentManagerInterface
     */
    protected $commentManager;

    /**
     * @param \Symfony\Component\Security\Acl\Dbal\MutableAclProvider
     */
    protected $aclProvider;

    /**
     * @param \CoreBundle\Doctrine\PostCommentManagerInterface $commentManager
     * @param \Symfony\Component\Security\Acl\Dbal\MutableAclProvider $aclProvider
     */
    public function __construct(PostCommentManagerInterface $commentManager, MutableAclProvider $aclProvider)
    {
        $this->commentManager = $commentManager;
        $this->aclProvider = $aclProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function createComment(PostCommentInterface $comment, PostInterface $post, UserInterface $respondent)
    {
        $comment->setPost($post);
        $comment->setRespondent($respondent);
        $comment->setState(PostCommentInterface::STATE_ACTIVE);

        // Persist object
        $this->commentManager->updateComment($comment);

        // Create ACL
        $this->createAcl($comment, $respondent);
    }

    /**
     * {@inheritDoc}
     */
    public function updateComment(PostCommentInterface $comment)
    {
        $this->commentManager->updateComment($comment);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteComment(PostCommentInterface $comment)
    {
        // Delete ACL
        $this->deleteAcl($comment);

        $this->commentManager->deleteComment($comment);
    }

    /**
     * {@inheritDoc}
     */
    public function getCommentManager()
    {
        return $this->commentManager;
    }

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     * @param \CoreBundle\Entity\UserInterface $user
     * @param integer $mask
     */
    protected function createAcl(PostCommentInterface $comment, UserInterface $user, $mask = MaskBuilder::MASK_OWNER)
    {
        $aclProvider = $this->aclProvider;

        // Create ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($comment);
        $acl = $aclProvider->createAcl($objectIdentity);

        // Creating user security identity
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // Grant owner access
        $acl->insertObjectAce($securityIdentity, $mask);
        $aclProvider->updateAcl($acl);
    }

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     */
    protected function deleteAcl(PostCommentInterface $comment)
    {
        $aclProvider = $this->aclProvider;

        // Delete ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($comment);
        $aclProvider->deleteAcl($objectIdentity);
    }
}
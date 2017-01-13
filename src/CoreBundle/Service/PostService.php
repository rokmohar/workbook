<?php

namespace CoreBundle\Service;

use CoreBundle\Doctrine\PostManagerInterface;
use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\UserInterface;
use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class PostService implements PostServiceInterface
{
    /**
     * @var \CoreBundle\Doctrine\PostManagerInterface
     */
    protected $postManager;

    /**
     * @param \Symfony\Component\Security\Acl\Dbal\MutableAclProvider
     */
    protected $aclProvider;

    /**
     * @param \CoreBundle\Doctrine\PostManagerInterface $postManager
     * @param \Symfony\Component\Security\Acl\Dbal\MutableAclProvider $aclProvider
     */
    public function __construct(PostManagerInterface $postManager, MutableAclProvider $aclProvider)
    {
        $this->postManager = $postManager;
        $this->aclProvider = $aclProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function createPost(PostInterface $post, UserInterface $user)
    {
        $post->setUser($user);
        $post->setState(PostInterface::STATE_ACTIVE);

        // Persist object
        $this->postManager->updatePost($post);

        // Create ACL
        $this->createAcl($post, $user);
    }

    /**
     * {@inheritDoc}
     */
    public function updatePost(PostInterface $post)
    {
        $this->postManager->updatePost($post);
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost(PostInterface $post)
    {
        // Delete ACL
        $this->deleteAcl($post);

        $this->postManager->deletePost($post);
    }

    /**
     * {@inheritDoc}
     */
    public function getPostManager()
    {
        return $this->postManager;
    }

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     * @param \CoreBundle\Entity\UserInterface $user
     * @param integer $mask
     */
    protected function createAcl(PostInterface $post, UserInterface $user, $mask = MaskBuilder::MASK_OWNER)
    {
        $aclProvider = $this->aclProvider;

        // Create ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($post);
        $acl = $aclProvider->createAcl($objectIdentity);

        // Creating user security identity
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // Grant access to object
        $acl->insertObjectAce($securityIdentity, $mask);
        $aclProvider->updateAcl($acl);
    }

    /**
     * @param \CoreBundle\Entity\PostInterface $post
     */
    protected function deleteAcl(PostInterface $post)
    {
        $aclProvider = $this->aclProvider;

        // Delete ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($post);
        $aclProvider->deleteAcl($objectIdentity);
    }
}

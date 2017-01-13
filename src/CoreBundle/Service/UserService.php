<?php

namespace CoreBundle\Service;

use CoreBundle\Doctrine\UserManagerInterface;
use CoreBundle\Entity\UserInterface;
use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class UserService implements UserServiceInterface
{
    /**
     * @var \CoreBundle\Doctrine\UserManagerInterface
     */
    protected $userManager;

    /**
     * @var \Symfony\Component\Security\Acl\Dbal\MutableAclProvider
     */
    protected $aclProvider;

    /**
     * @param \CoreBundle\Doctrine\UserManagerInterface $userManager
     * @param \Symfony\Component\Security\Acl\Dbal\MutableAclProvider $aclProvider
     */
    public function __construct(UserManagerInterface $userManager, MutableAclProvider $aclProvider)
    {
        $this->userManager = $userManager;
        $this->aclProvider = $aclProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function createUser(UserInterface $user)
    {
        $user->setState(UserInterface::STATE_ACTIVE);

        // Persist object
        $this->userManager->updateUser($user);

        // Create ACL
        $this->createAcl($user);
    }

    /**
     * {@inheritDoc}
     */
    public function updateUser(UserInterface $user)
    {
        $this->userManager->updateUser($user);

        // todo: update user security identity
    }

    /**
     * {@inheritDoc}
     */
    public function deleteUser(UserInterface $user)
    {
        // Delete ACL
        $this->deleteAcl($user);

        // todo: delete user security identity

        $this->userManager->deleteUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserManager()
    {
        return $this->userManager;
    }

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     * @param integer $mask
     */
    protected function createAcl(UserInterface $user, $mask = MaskBuilder::MASK_OWNER)
    {
        $aclProvider = $this->aclProvider;

        // Creating a ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($user);
        $acl = $aclProvider->createAcl($objectIdentity);

        // Creating user security identity
        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // Grant access to object
        $acl->insertObjectAce($securityIdentity, $mask);
        $aclProvider->updateAcl($acl);
    }

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    protected function deleteAcl(UserInterface $user)
    {
        $aclProvider = $this->aclProvider;

        // Delete the ACL
        $objectIdentity = ObjectIdentity::fromDomainObject($user);
        $aclProvider->deleteAcl($objectIdentity);
    }
}

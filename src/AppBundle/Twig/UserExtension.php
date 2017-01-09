<?php

namespace AppBundle\Twig;

use CoreBundle\Entity\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('is_owner', array($this, 'isOwner')),
        );
    }

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     *
     * @return boolean
     */
    public function isOwner(UserInterface $user)
    {
        return ($token = $this->tokenStorage->getToken()) ? $user->equals($token->getUser()) : false;
    }

    public function getName()
    {
        return 'app_extension';
    }
}
<?php

namespace CoreBundle\Util;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordEncoder implements PasswordEncoderInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    protected $encoderFactory;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface
     */
    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function hashPassword(UserInterface $user)
    {
        $plainPassword = $user->getPlainPassword();

        if (strlen($plainPassword) !== 0) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());

            $user->setPassword($password);
            $user->eraseCredentials();
        }
    }
}
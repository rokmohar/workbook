<?php

namespace CoreBundle\Util;

use Symfony\Component\Security\Core\User\UserInterface;

interface PasswordEncoderInterface
{
    /**
     * Updates the hashed password in the user when there is a new password.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     */
    public function hashPassword(UserInterface $user);
}

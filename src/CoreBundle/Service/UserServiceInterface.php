<?php

namespace CoreBundle\Service;

use CoreBundle\Entity\UserInterface;

interface UserServiceInterface
{
    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function createUser(UserInterface $user);

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function updateUser(UserInterface $user);

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function deleteUser(UserInterface $user);

    /**
     * @return \CoreBundle\Doctrine\UserManagerInterface
     */
    public function getUserManager();
}

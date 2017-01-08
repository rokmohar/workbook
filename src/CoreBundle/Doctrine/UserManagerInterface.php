<?php

namespace CoreBundle\Doctrine;

use CoreBundle\Entity\UserInterface;

interface UserManagerInterface
{
    /**
     * @return \CoreBundle\Entity\UserInterface
     */
    public function createUser();

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function updateUser(UserInterface $user);

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     */
    public function deleteUser(UserInterface $user);

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

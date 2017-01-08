<?php

namespace CoreBundle\Doctrine;

use CoreBundle\Entity\AdminInterface;

interface AdminManagerInterface
{
    /**
     * @return \CoreBundle\Entity\AdminInterface
     */
    public function createAdmin();

    /**
     * @param \CoreBundle\Entity\AdminInterface $admin
     */
    public function updateAdmin(AdminInterface $admin);

    /**
     * @param \CoreBundle\Entity\AdminInterface $admin
     */
    public function deleteAdmin(AdminInterface $admin);

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

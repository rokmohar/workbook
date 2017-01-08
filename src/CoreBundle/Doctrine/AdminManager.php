<?php

namespace CoreBundle\Doctrine;

use CoreBundle\Entity\AdminInterface;
use CoreBundle\Util\PasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AdminManager implements AdminManagerInterface
{
    /**
     * @var \CoreBundle\Util\PasswordEncoderInterface
     */
    protected $passwordEncoder;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $objectRepository;

    /**
     * @var string
     */
    protected $className;

    /**
     * Constructor.
     *
     * @param \CoreBundle\Util\PasswordEncoderInterface $passwordEncoder
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param string $className
     */
    public function __construct(PasswordEncoderInterface $passwordEncoder, ObjectManager $objectManager, $className)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->objectManager = $objectManager;
        $this->objectRepository = $objectManager->getRepository($className);

        $classMetadata = $objectManager->getClassMetadata($className);
        $this->className = $classMetadata->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function createAdmin()
    {
        $className = $this->getClassName();

        return new $className();
    }

    /**
     * {@inheritDoc}
     */
    public function updateAdmin(AdminInterface $admin, $andFlush = true)
    {
        $this->hashPassword($admin);

        $this->objectManager->persist($admin);

        if ($andFlush === true) {
            $this->objectManager->flush();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteAdmin(AdminInterface $admin)
    {
        $this->objectManager->remove($admin);
        $this->objectManager->flush();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getObjectRepository()
    {
        return $this->objectRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Hash plain password.
     *
     * @param \CoreBundle\Entity\AdminInterface $admin
     */
    protected function hashPassword(AdminInterface $admin)
    {
        $this->passwordEncoder->hashPassword($admin);
    }
}

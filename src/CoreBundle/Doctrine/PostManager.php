<?php

namespace CoreBundle\Doctrine;

use CoreBundle\Entity\PostInterface;
use CoreBundle\Util\PasswordEncoderInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PostManager implements PostManagerInterface
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
    public function createPost()
    {
        $className = $this->getClassName();

        return new $className();
    }

    /**
     * {@inheritDoc}
     */
    public function updatePost(PostInterface $post, $andFlush = true)
    {
        $this->objectManager->persist($post);

        if ($andFlush === true) {
            $this->objectManager->flush();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function deletePost(PostInterface $post)
    {
        $this->objectManager->remove($post);
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
}

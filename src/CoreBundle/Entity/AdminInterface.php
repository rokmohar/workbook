<?php

namespace CoreBundle\Entity;

interface AdminInterface extends \Symfony\Component\Security\Core\User\UserInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     */
    public function setId($id);

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt);
}
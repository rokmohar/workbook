<?php

namespace AppBundle\Twig;

use AppBundle\Form\PostCommentType;
use CoreBundle\Entity\PostComment;
use CoreBundle\Entity\PostCommentInterface;
use CoreBundle\Entity\UserInterface;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TwigExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\Form\FormFactory
     */
    protected $formFactory;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Form\FormFactory $formFactory
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     */
    public function __construct(FormFactory $formFactory, TokenStorageInterface $tokenStorage)
    {
        $this->formFactory = $formFactory;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('time_ago', array($this, 'timeAgo')),
        );
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('comment_form', array($this, 'commentForm')),
            new \Twig_SimpleFunction('is_owner', array($this, 'isOwner')),
            new \Twig_SimpleFunction('is_respondent', array($this, 'isRespondent')),
        );
    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function commentForm()
    {
        $commentForm = $this->formFactory->create(PostCommentType::class, new PostComment());

        return $commentForm->createView();
    }

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     *
     * @return boolean
     */
    public function isOwner(UserInterface $user)
    {
        return ($token = $this->tokenStorage->getToken()) ? $user->isEqual($token->getUser()) : false;
    }

    /**
     * @param \CoreBundle\Entity\PostCommentInterface $comment
     *
     * @return boolean
     */
    public function isRespondent(PostCommentInterface $comment)
    {
        return $this->isOwner($comment->getRespondent());
    }

    /**
     * @param \DateTime $datetime
     *
     * @return string
     */
    public function timeAgo(\DateTime $datetime)
    {
        $time = time() - $datetime->getTimestamp();

        $units = array(
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($units as $unit => $val) {
            if ($unit <= $time) {
                $numberOfUnits = floor($time / $unit);

                return ($val == 'second') ? 'a few seconds ago' : sprintf("%s %s%s ago",
                    (1 < $numberOfUnits) ? $numberOfUnits : 'a',
                    $val,
                    (1 < $numberOfUnits) ? 's' : ''
                );
            }
        }

        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_extension';
    }
}
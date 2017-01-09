<?php

namespace AppBundle\Controller;

use CoreBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    /**
     * @param \CoreBundle\Entity\User $user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/profile/{id}", name="profile")
     */
    public function indexAction(User $user)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Profile:index.html.twig', array(
            'user' => $user,
        ));
    }
}

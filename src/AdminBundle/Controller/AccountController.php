<?php

namespace AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('AdminBundle:Account:login.html.twig', array(
            'lastUsername' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/admin/logout", name="admin_logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException();
    }
}

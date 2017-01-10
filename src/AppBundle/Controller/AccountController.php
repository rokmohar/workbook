<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use CoreBundle\Entity\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('AppBundle:Account:login.html.twig', array(
            'lastUsername' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $userForm = $this->createForm(UserType::class, null, array(
            'validation_groups' => ['register'],
        ));
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() &&$userForm->isValid()) {
            /** @var \CoreBundle\Entity\UserInterface $user */
            $user = $userForm->getData();

            // Set default data
            $user->setState(UserInterface::STATE_ACTIVE);

            /** @var \CoreBundle\Doctrine\UserManagerInterface $manager */
            $manager = $this->get('workbook.user_manager');
            $manager->updateUser($user);

            return $this->redirectToRoute('login');
        }

        return $this->render('AppBundle:Account:register.html.twig', array(
            'userForm' => $userForm->createView(),
        ));
    }
}

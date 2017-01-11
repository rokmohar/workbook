<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostType;
use CoreBundle\Entity\Post;
use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    /**
     * @param \CoreBundle\Entity\User $user
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/profile/{id}", name="profile")
     */
    public function indexAction(User $user, Request $request)
    {
        /** @var \CoreBundle\Doctrine\PostManagerInterface $manager */
        $manager = $this->get('workbook.post_manager');

        $postForm = $this->createForm(PostType::class, new Post());
        $postForm->handleRequest($request);

        /** @var \CoreBundle\Entity\UserInterface $self */
        $self = $this->getUser();

        if ($postForm->isSubmitted()) {
            if (!$user->isEqual($self)) {
                throw new \RuntimeException();
            }

            if ($postForm->isValid()) {

                /** @var \CoreBundle\Entity\PostInterface $post */
                $post = $postForm->getData();

                // Set default values
                $post->setUser($self);
                $post->setState(PostInterface::STATE_ACTIVE);

                $manager->updatePost($post);

                $this->redirectToRoute('profile', ['id' => $user->getId()]);
            }
        }

        /** @var \CoreBundle\Repository\PostRepository $repository */
        $repository = $manager->getObjectRepository();

        return $this->render('AppBundle:Profile:index.html.twig', array(
            'postForm' => $postForm->createView(),
            'timeline' => $repository->findPostsByUser($user, $self),
            'user' => $user,
        ));
    }
}

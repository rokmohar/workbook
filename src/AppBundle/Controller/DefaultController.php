<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostType;
use CoreBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var \CoreBundle\Doctrine\PostManagerInterface $manager */
        $manager = $this->get('workbook.post_manager');

        // Create an empty object
        $post = new Post();

        // Create a form
        $postForm = $this->createForm(PostType::class, $post, array(
            'state_disabled' => true,
            'validation_groups' => ['create'],
        ));
        $postForm->handleRequest($request);

        /** @var \CoreBundle\Entity\UserInterface $user */
        $user = $this->getUser();

        if ($postForm->isSubmitted() && $postForm->isValid()) {
            /** @var \CoreBundle\Service\PostServiceInterface $postService */
            $postService = $this->get('workbook.post_service');
            $postService->createPost($post, $user);

            return $this->redirectToRoute('homepage');
        }

        /** @var \CoreBundle\Repository\PostRepository $repository */
        $repository = $manager->getObjectRepository();

        return $this->render('AppBundle:Default:index.html.twig', array(
            'postForm' => $postForm->createView(),
            'timeline' => $repository->getTimeline($user),
        ));
    }
}

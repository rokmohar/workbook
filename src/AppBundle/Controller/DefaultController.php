<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostCommentType;
use AppBundle\Form\PostType;
use CoreBundle\Entity\Post;
use CoreBundle\Entity\PostComment;
use CoreBundle\Entity\PostInterface;
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

        $postForm = $this->createForm(PostType::class, new Post(), array(
            'validation_groups' => ['create'],
        ));
        $postForm->handleRequest($request);

        /** @var \CoreBundle\Entity\UserInterface $self */
        $self = $this->getUser();

        if ($postForm->isSubmitted() && $postForm->isValid()) {
            /** @var \CoreBundle\Entity\PostInterface $post */
            $post = $postForm->getData();
            $post->setUser($self);
            $post->setState(PostInterface::STATE_ACTIVE);

            $manager->updatePost($post);

            return $this->redirectToRoute('homepage');
        }

        /** @var \CoreBundle\Repository\PostRepository $repository */
        $repository = $manager->getObjectRepository();

        return $this->render('AppBundle:Default:index.html.twig', array(
            'postForm' => $postForm->createView(),
            'timeline' => $repository->getTimeline($self),
        ));
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostCommentType;
use CoreBundle\Entity\Post;
use CoreBundle\Entity\PostComment;
use CoreBundle\Entity\PostCommentInterface;
use CoreBundle\Entity\PostInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @param \CoreBundle\Entity\Post $post
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     *
     * @Route("/post/{id}", name="post")
     */
    public function commentAction(Post $post, Request $request)
    {
        /** @var \CoreBundle\Entity\UserInterface $user */
        $user = $this->getUser();

        $author = $post->getUser();

        if (!$author->isEqual($user)) {
            if ($post->getPrivacy() === PostInterface::PRIVACY_PRIVATE) {
                throw $this->createAccessDeniedException();
            }

            if ($post->getPrivacy() === PostInterface::PRIVACY_FRIENDS && !$author->isFriend($user)) {
                throw $this->createAccessDeniedException();
            }
        }

        $commentForm = $this->createForm(PostCommentType::class, new PostComment(), array(
            'validation_groups' => ['create'],
        ));
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            /** @var \CoreBundle\Entity\PostCommentInterface $comment */
            $comment = $commentForm->getData();
            $comment->setRespondent($user);
            $comment->setState(PostCommentInterface::STATE_ACTIVE);

            $post->addComment($comment);

            /** @var \CoreBundle\Doctrine\PostManagerInterface $manager */
            $manager = $this->get('workbook.post_manager');
            $manager->updatePost($post);

            return $this->redirectToRoute('post', ['id' => $post->getId()]);
        }

        return $this->render('AppBundle:Post:comment.html.twig', array(
            'commentForm' => $commentForm->createView(),
            'post' => $post,
        ));
    }
}

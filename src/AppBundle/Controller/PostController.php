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

class PostController extends Controller
{
    /**
     * @param \CoreBundle\Entity\Post $post
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     *
     * @Route("/post/{id}", name="post")
     */
    public function indexAction(Post $post, Request $request)
    {
        /** @var \CoreBundle\Entity\UserInterface $user */
        $user = $this->getUser();

        if (!$post->getUser()->isEqual($user)) {
            if ($post->getPrivacy() === PostInterface::PRIVACY_PRIVATE) {
                throw $this->createAccessDeniedException();
            }

            if ($post->getPrivacy() === PostInterface::PRIVACY_FRIENDS && !$post->getUser()->isFriend($user)) {
                throw $this->createAccessDeniedException();
            }
        }

        // Create an empty object
        $comment = new PostComment();

        $commentForm = $this->createForm(PostCommentType::class, $comment, array(
            'validation_groups' => ['create'],
        ));
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            /** @var \CoreBundle\Service\PostCommentServiceInterface $commentService */
            $commentService = $this->get('workbook.post_comment_service');
            $commentService->createComment($comment, $post, $user);

            return $this->redirectToRoute('post', ['id' => $post->getId()]);
        }

        return $this->render('AppBundle:Post:index.html.twig', array(
            'commentForm' => $commentForm->createView(),
            'post' => $post,
        ));
    }

    /**
     * @param \CoreBundle\Entity\Post $post
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return mixed
     *
     * @Route("/post/{id}/edit", name="post_edit")
     */
    public function editAction(Post $post, Request $request)
    {
        /** @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker */
        $authorizationChecker = $this->get('security.authorization_checker');

        if (!$authorizationChecker->isGranted('EDIT', $post)) {
            throw $this->createAccessDeniedException();
        }

        // Create a form
        $postForm = $this->createForm(PostType::class, $post, array(
            'state_disabled' => true,
            'validation_groups' => ['update'],
        ));
        $postForm->handleRequest($request);

        if ($postForm->isSubmitted() && $postForm->isValid()) {
            /** @var \CoreBundle\Service\PostServiceInterface $postService */
            $postService = $this->get('workbook.post_service');
            $postService->updatePost($post);

            return $this->redirectToRoute('post', ['id' => $post->getId()]);
        }

        return $this->render('AppBundle:Post:edit.html.twig', array(
            'post' => $post,
            'postForm' => $postForm->createView(),
        ));
    }

    /**
     * @param \CoreBundle\Entity\Post $post
     * @return mixed
     *
     * @Route("/post/{id}/delete", name="post_delete")
     */
    public function deleteAction(Post $post)
    {
        /** @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker */
        $authorizationChecker = $this->get('security.authorization_checker');

        if (!$authorizationChecker->isGranted('DELETE', $post)) {
            throw $this->createAccessDeniedException();
        }

        /** @var \CoreBundle\Service\PostServiceInterface $postService */
        $postService = $this->get('workbook.post_service');
        $postService->deletePost($post);

        return $this->redirectToRoute('profile', ['id' => $post->getUser()->getId()]);

    }
}

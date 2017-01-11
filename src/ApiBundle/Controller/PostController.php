<?php

namespace ApiBundle\Controller;

use CoreBundle\Entity\PostComment;
use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\PostReaction;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PostController extends FOSRestController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @FOS\Post("/post/reaction", name="api_post_reaction")
     */
    public function postReactionAction(Request $request)
    {
        $postId = $request->get('post_id');

        if (!$postId) {
            return new JsonResponse(array(
                'message' => 'Parameter \'post_id\' is required.',
            ), 400);
        }

        $userId = $request->get('user_id');

        if (!$userId) {
            return new JsonResponse(array(
                'message' => 'Parameter \'user_id\' is required.',
            ), 400);
        }

        $postRepository = $this->getPostRepository();

        /** @var \CoreBundle\Entity\PostInterface $post */
        $post = $postRepository->find($postId);

        if (!$post) {
            return new JsonResponse(array(
                'message' => sprintf('Post with identifier \'%s\' does no exist.', $postId),
            ), 404);
        }

        $userRepository = $this->getUserRepository();

        /** @var \CoreBundle\Entity\UserInterface $user */
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(array(
                'message' => sprintf('User with identifier \'%s\' does no exist.', $userId),
            ), 404);
        }

        $author = $post->getUser();

        if (!$author->isEqual($user)) {
            if ($post->getPrivacy() === PostInterface::PRIVACY_PRIVATE) {
                return new JsonResponse(array(
                    'message' => 'User is not allowed to react to this post.',
                ), 403);
            }

            if ($post->getPrivacy() === PostInterface::PRIVACY_FRIENDS && !$author->isFriend($user)) {
                return new JsonResponse(array(
                    'message' => 'User is not friend of this post\'s author.',
                ), 403);
            }
        }

        $post->addReaction($user);

        $postManager = $this->getPostManager();
        $postManager->updatePost($post);

        return new JsonResponse();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @FOS\Delete("/post/reaction", name="api_delete_reaction")
     */
    public function deleteReactionAction(Request $request)
    {
        $postId = $request->get('post_id');

        if (!$postId) {
            return new JsonResponse(array(
                'message' => 'Parameter \'post_id\' is required.',
            ), 400);
        }

        $userId = $request->get('user_id');

        if (!$userId) {
            return new JsonResponse(array(
                'message' => 'Parameter \'user_id\' is required.',
            ), 400);
        }

        $postRepository = $this->getPostRepository();

        /** @var \CoreBundle\Entity\PostInterface $post */
        $post = $postRepository->find($postId);

        if (!$post) {
            return new JsonResponse(array(
                'message' => sprintf('Post with identifier \'%s\' does no exist.', $postId),
            ), 404);
        }

        $userRepository = $this->getUserRepository();

        /** @var \CoreBundle\Entity\UserInterface $user */
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(array(
                'message' => sprintf('User with identifier \'%s\' does no exist.', $userId),
            ), 404);
        }

        $author = $post->getUser();

        if (!$author->isEqual($user)) {
            if ($post->getPrivacy() === PostInterface::PRIVACY_PRIVATE) {
                return new JsonResponse(array(
                    'message' => 'User is not allowed to react to this post.',
                ), 403);
            }

            if ($post->getPrivacy() === PostInterface::PRIVACY_FRIENDS && !$author->isFriend($user)) {
                return new JsonResponse(array(
                    'message' => 'User is not friend of this post\'s author.',
                ), 403);
            }
        }

        $post->removeReaction($user);

        $postManager = $this->getPostManager();
        $postManager->updatePost($post);

        return new JsonResponse();
    }

    /**
     * @return \CoreBundle\Doctrine\PostManagerInterface
     */
    protected function getPostManager()
    {
        return $this->get('workbook.post_manager');
    }

    /**
     * @return \CoreBundle\Repository\PostRepository
     */
    protected function getPostRepository()
    {
        return $this->getPostManager()->getObjectRepository();
    }

    /**
     * @return \CoreBundle\Doctrine\UserManagerInterface
     */
    protected function getUserManager()
    {
        return $this->get('workbook.user_manager');
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getUserRepository()
    {
        return $this->getUserManager()->getObjectRepository();
    }
}

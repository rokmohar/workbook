<?php

namespace AppBundle\Controller;

use AppBundle\Form\PostCommentType;
use AppBundle\Form\PostType;
use CoreBundle\Entity\Post;
use CoreBundle\Entity\PostComment;
use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class ProfileController extends Controller
{
    /**
     * @param \CoreBundle\Entity\User $profile
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/profile/{id}", name="profile")
     */
    public function indexAction(User $profile, Request $request)
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

        if ($postForm->isSubmitted()) {
            if (!$profile->isEqual($user)) {
                throw new \RuntimeException();
            }

            if ($postForm->isValid()) {
                /** @var \CoreBundle\Service\PostServiceInterface $postService */
                $postService = $this->get('workbook.post_service');
                $postService->createPost($post, $user);

                return $this->redirectToRoute('profile', ['id' => $profile->getId()]);
            }
        }

        /** @var \CoreBundle\Repository\PostRepository $repository */
        $repository = $manager->getObjectRepository();

        return $this->render('AppBundle:Profile:index.html.twig', array(
            'postForm' => $postForm->createView(),
            'profile' => $profile,
            'timeline' => $repository->findPostsByUser($profile, $user),
        ));
    }
}

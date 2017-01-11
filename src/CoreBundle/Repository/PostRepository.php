<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\PostInterface;
use CoreBundle\Entity\UserInterface;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * @param \CoreBundle\Entity\UserInterface $user
     * @param \CoreBundle\Entity\UserInterface $guest
     * @return array
     */
    public function findPostsByUser(UserInterface $user, UserInterface $guest)
    {
        $qb = $this->createQueryBuilder('p');

        $privacy = array(
            PostInterface::PRIVACY_PUBLIC,
        );

        if ($guest->isEqual($user)) {
            $privacy[] = PostInterface::PRIVACY_FRIENDS;
            $privacy[] = PostInterface::PRIVACY_PRIVATE;
        }
        else if ($user->isFriend($guest)) {
            $privacy[] = PostInterface::PRIVACY_FRIENDS;
        }

        $qb
            ->where($qb->expr()->andX(
                $qb->expr()->eq('p.user', ':creator'),
                $qb->expr()->in('p.privacy', ':privacy')
            ))
            ->orderBy('p.createdAt', 'DESC')
            ->setParameters(array(
                'creator' => $user,
                'privacy' => $privacy,
            ))
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param \CoreBundle\Entity\UserInterface $user
     * @return array
     */
    public function getTimeline(UserInterface $user)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where($qb->expr()->orX(
                $qb->expr()->eq('p.user', ':creator'),
                $qb->expr()->andX(
                    $qb->expr()->in('p.user', ':people'),
                    $qb->expr()->orX(
                        $qb->expr()->eq('p.privacy', 0),
                        $qb->expr()->eq('p.privacy', 5)
                    )
                )
            ))
            ->orderBy('p.createdAt', 'DESC')
            ->setParameters(array(
                'creator' => $user,
                'people' => $user->getFriends()->toArray(),
            ))
        ;

        return $qb->getQuery()->getResult();
    }
}
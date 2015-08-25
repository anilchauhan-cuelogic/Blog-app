<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CommentsRepository extends EntityRepository
{
	public function findAllCommentsByPostId($postId)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c FROM AppBundle:Comments c where c.post = :postId')
            ->setParameter('postId', $postId)
            ->getResult();
    }
}

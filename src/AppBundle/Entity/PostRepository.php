<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
	public function fetchAllPosts()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM AppBundle:Post p ORDER BY p.createdOn DESC')
            ->getResult();
    }

    public function fetchPostById($id)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM AppBundle:Post p WHERE p.id = :id')
            ->setParameter('id', $id)
            ->getResult();
    }
}

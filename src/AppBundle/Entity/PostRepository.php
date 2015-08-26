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

    public function fetchAllActivePosts()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM AppBundle:Post p WHERE p.isActive = 1 ORDER BY p.createdOn DESC')
            ->getResult();
    }

    public function fetchActivePostById($id)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT p FROM AppBundle:Post p WHERE p.id = :id AND p.isActive = 1')
            ->setParameter('id', $id)
            ->getResult();
    }
}

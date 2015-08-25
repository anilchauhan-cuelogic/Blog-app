<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setTitle('Test title');
        $post->setDescription('Test description');
        $post->setUser($manager->getRepository('AppBundle\Entity\User')->findOneByUsername('super_admin'));
        $post->setIsActive(1);
        $post->setCreatedOn(new \DateTime());
        $post->setUpdatedOn(new \DateTime());

        $manager->persist($post);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}
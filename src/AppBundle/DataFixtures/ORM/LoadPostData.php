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
        $post->setTitle('Man must explore, and this is exploration at its greatest');
        $post->setDescription('Never in all their history have men been able truly to conceive of 
                                the world as one: a single sphere, a globe, having the qualities of 
                                a globe, a round earth in which all the directions eventually meet, 
                                in which there is no center because every point, or none, is center — 
                                an equal earth which all men occupy as equals. The airman\'s earth, if
                                free men make it, will be truly round: a globe in practice, not in theory.');
        $post->setUser($manager->merge($this->getReference('super_admin_user')));
        $post->setIsActive(1);
        $post->setCreatedOn(new \DateTime());
        $post->setUpdatedOn(new \DateTime());

        $post1 = new Post();
        $post1->setTitle('New in Symfony 2.6: Bootstrap form theme');
        $post1->setDescription('Bootstrap is the most popular HTML, CSS, and JavaScript framework for developing 
                                responsive, mobile first projects on the web. Bootstrap is so widely used that it 
                                has become the de facto standard for frontend development. That\'s why Symfony 2.6 
                                will include a new form theme designed for Bootstrap 3.');
        $post1->setUser($manager->merge($this->getReference('super_admin_user')));
        $post1->setIsActive(1);
        $post1->setCreatedOn(new \DateTime());
        $post1->setUpdatedOn(new \DateTime());

        $post2 = new Post();
        $post2->setTitle('Symfony Doctine data fixtures');
        $post2->setDescription('Fixtures are used to load a controlled set of data into a database. This data 
                                can be used for testing or could be the initial data required for the application
                                to run smoothly. Symfony2 has no built in way to manage fixtures but Doctrine2 has 
                                 a library to help you write fixtures for the Doctrine ORM or ODM.');
        $post2->setUser($manager->merge($this->getReference('super_admin_user')));
        $post2->setIsActive(1);
        $post2->setCreatedOn(new \DateTime());
        $post2->setUpdatedOn(new \DateTime());

        $manager->persist($post);
        $manager->persist($post1);
        $manager->persist($post2);

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
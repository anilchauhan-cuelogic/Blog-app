<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstname('Super');
        $user->setLastname('Admin');
        $user->setUsername('super_Admin');
        $user->setEmailId('anil.chauhan@cuelogic.co.in');
        $user->setPassword($this->container->get('security.password_encoder')->encodePassword($user, '123456'));
        $user->setRole($manager->merge($this->getReference('role-super-admin')));
        $user->setCreatedOn(new \DateTime());

        $manager->persist($user);
        $manager->flush();

        $this->addReference('super_admin_user', $user);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
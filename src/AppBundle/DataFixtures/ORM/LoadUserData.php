<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('super_admin');
        $user->setEmailId('anil.chauhan@cuelogic.co.in');
        $user->setPassword('$2y$12$FFw7t0zjxtVgS35.MIlMBuI0.DIvT3x0nLGhB5ZwUPaF0fyPozCOy');
        $user->setRole($manager->getRepository('AppBundle\Entity\Role')->findOneByName('ROLE_SUPER_ADMIN'));
        $user->setCreatedOn(new \DateTime());

        $manager->persist($user);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}
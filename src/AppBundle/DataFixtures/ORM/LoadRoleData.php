<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Role;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
	/**
     * {@inheritDoc}
     */
	public function load(ObjectManager $manager){

		$superAdmin = new Role();
		$superAdmin->setName('ROLE_SUPER_ADMIN');

		$admin = new Role();
		$admin->setName('ROLE_ADMIN');

		$editor = new Role();
		$editor->setName('ROLE_EDITOR');

		$manager->persist($superAdmin);
		$manager->persist($admin);
		$manager->persist($editor);

		$manager->flush();

		$this->addReference('role-super-admin', $superAdmin);
	}

	/**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}

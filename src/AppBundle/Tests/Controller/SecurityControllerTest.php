<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('login')->form();
        
        //Invalid Data
		$crawler = $client->submit($form, array(
			'_username' => 'super_admin',
			'_password' => '123454556',
		));

		$crawler = $client->followRedirect();

		$this->assertGreaterThan(0,$crawler->filter('html:contains("Invalid credentials")')->count());
		
        //Valid Data
		$crawler = $client->submit($form, array(
			'_username' => 'super_admin',
			'_password' => '123456',
		));

		$crawler = $client->followRedirect();

		$this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("A Simple Blog by Anil")')->count()
        );

		//Already logged in
        $crawler = $client->request('GET', '/login');

        $crawler = $client->followRedirect();

        $crawler->filter('html:contains("A Simple Blog by Anil")')->count();
		
    }
}
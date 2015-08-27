<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    protected static $USER = 'super_admin';
    protected static $PASS = '123456';

    public function testManageUser() {

        $client = static::createClient(array(), array('PHP_AUTH_USER'=>self::$USER, 'PHP_AUTH_PW' => self::$PASS));
        
        $crawler = $client->request('GET', '/manage/user/new');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // $form = $crawler->selectButton('Create')->form();

        // print_r($form);exit;
        $form = $crawler->selectButton('Create')->form(array(
            'appbundle_user[firstname]'  => 'Anil',
            'appbundle_user[lastname]'  => 'Chauhan',
            'appbundle_user[username]'  => 'anil',
            'appbundle_user[emailId]'  => 'anil@gmail.com',
            'appbundle_user[password][password]'  => 'password',
            'appbundle_user[password][confirmPassword]'  => 'password'
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();
        
        //Assert inserted value
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Anil")')->count(), 'Missing element td:contains("Anil")');

        //Edit values
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'appbundle_user[emailId]'  => 'anil@yahoo.com',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('[value="anil@yahoo.com"]')->count(), 'Missing element [value="anil@yahoo.com"]');

        //Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/anil@yahoo.com/', $client->getResponse()->getContent());
    }
}

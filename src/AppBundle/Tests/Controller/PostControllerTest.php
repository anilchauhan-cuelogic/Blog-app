<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{

    protected static $USER = 'super_admin';
    protected static $PASS = '123456';

    public function testManagePosts() {

        $client = static::createClient(array(), array('PHP_AUTH_USER'=>self::$USER, 'PHP_AUTH_PW' => self::$PASS));
        
        $crawler = $client->request('GET', '/manage/post/new');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Create')->form(array(
            'appbundle_post[title]'  => 'Test title',
            'appbundle_post[description]'  => 'Test description',
            'appbundle_post[isActive]'  => 1,
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();
        
        //Assert inserted value
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test title")')->count(), 'Missing element td:contains("Test title")');

        //Edit values
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'appbundle_post[title]'  => 'Test title changed',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('[value="Test title changed"]')->count(), 'Missing element [value="Test title changed"]');

        //Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Test title changed/', $client->getResponse()->getContent());
    }
}

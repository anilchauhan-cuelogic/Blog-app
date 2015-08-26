<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    public function testPostList() {
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
      	
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPostComments() {
        
        $client = static::createClient();
        $db = $client->getContainer()->get('database_connection');

        $postId = $db->fetchColumn( "SELECT id FROM post ORDER BY id DESC LIMIT 1" );

        $client = static::createClient();
        $crawler = $client->request('GET', '/post/'.$postIds);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('submit')->form(array(
            'appbundle_comment[comment]'  => 'Test comment'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('div:contains("Test comment")')->count(), 'Missing element');
        
    }
}

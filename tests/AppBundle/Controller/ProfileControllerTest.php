<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class ProfileControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        // Login
        $crawler = $this->login($client);

        // Test homepage
        $this->assertEquals('/', $client->getRequest()->getPathInfo());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Click profile link
        $link = $crawler->filter('.nav > li > a')->eq(1)->link();
        $crawler = $client->click($link);

        // Test profile page
        $this->assertEquals('/profile/1', $client->getRequest()->getPathInfo());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(1, $crawler->filter('textarea[id=post_content]')->count());
    }

    /**
     * @param Client $client
     * @return Crawler
     */
    private function login(Client $client)
    {
        // GET homepage
        $client->request('GET', '/');

        // Test redirect
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();

        // Test login page
        $this->assertEquals('/login',$client->getRequest()->getPathInfo());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Submit form
        $form = $crawler->filter('button[type=submit]')->form(array(
            'email'    => 'user1@example.org',
            'password' => '123456',
        ), 'POST');
        $crawler = $client->submit($form);

        // Test redirect
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        return $client->followRedirect();
    }
}

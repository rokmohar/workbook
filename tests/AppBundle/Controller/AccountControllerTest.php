<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        // Test login page
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Submit form
        $form = $crawler->filter('button[type=submit]')->form(array(
            'email'    => 'user1@example.org',
            'password' => '123',
        ), 'POST');
        $crawler = $client->submit($form);

        // Test redirect
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();

        // Test login page
        $this->assertEquals('/login',$client->getRequest()->getPathInfo());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Test form error
        $this->assertContains('Invalid credentials.', $crawler->filter('[role=alert]')->text());

        // Submit form
        $form = $crawler->filter('button[type=submit]')->form(array(
            'email'    => 'user1@example.org',
            'password' => '123456',
        ), 'POST');
        $crawler = $client->submit($form);

        // Test redirect
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();

        // Test homepage
        $this->assertEquals('/',$client->getRequest()->getPathInfo());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

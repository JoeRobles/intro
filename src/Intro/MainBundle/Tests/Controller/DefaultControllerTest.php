<?php

namespace Intro\MainBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Intro\MainBundle\Controller\DefaultController;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/contact');

        $form = $crawler->selectButton('Submit')->form(
            array(
                'contact[subject]' => '40',
                'contact[name]' => '20',
                'contact[body]' => 'this is the body',
                'contact[email]' => 'joe@robles.com'
            )
        );
        $crawler = $client->submit($form);
        
        $this->assertTrue($crawler->filter('html:contains("Sum: 60")')->count() > 0);
    }
    
    public function testAdd()
    {
        $calc = new DefaultController();
        $result = $calc->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }
}

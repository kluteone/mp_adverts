<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostAdControllerTest extends WebTestCase
{
    public function testPostad()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'post_ad');
    }

}

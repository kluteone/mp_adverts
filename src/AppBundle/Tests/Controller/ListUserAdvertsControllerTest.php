<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListUserAdvertsControllerTest extends WebTestCase
{
    public function testListadvert()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'list_user_ads');
    }

}

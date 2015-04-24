<?php

namespace Sunahip\FiscalizacionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PDFControllerTest extends WebTestCase
{
    public function testVerificacion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/verificacion');
    }

}

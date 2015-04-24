<?php

namespace Sunahip\ReporteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReporteControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testLicencia()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/licencia');
    }

    public function testFiscalizacion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/rep_fiscalizacion');
    }

    public function testIngreso()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/rep_ingreso');
    }

    public function testUsuario()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/rep_usuario');
    }

    public function testEjecutivo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/rep_ejecutivo');
    }

}

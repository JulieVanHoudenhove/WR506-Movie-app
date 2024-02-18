<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    public function testLoginCheck()
    {
        $client = static::createClient();

        $client->request('GET', '/api', [], [], ['CONTENT_TYPE' => 'application/json']);

        $response = $client->getResponse();

        // Vérifiez le code de réponse HTTP
        // assetSame permet de vérifier que le type et la valeur des 2 valeurs passées sont identiques
        // ici que 401 == code HTTP de la réponse du point d'API
        $this->assertSame(401, $response->getStatusCode());
    }
}

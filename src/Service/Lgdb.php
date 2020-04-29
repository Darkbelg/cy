<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Exception\ClientException;

/**
 *
 * @method mixed gameVersions($body)
 */

class Lgdb {


    private $client;

    public function __construct()
    {
        $this->client = HttpClient::create(['headers' => [
            'user-key' => 'a8a077c98e0266d85f59744efc9858db',
        ]]);
        
    }

    public function __call($name, $arguments)
    {

        // Transform method name generateConsignmentNote to class name GenerateConsignmentNote
        $serviceClass = 'App\\Service\\' . ucfirst($name);

        // Check whether Service class exists
        if (class_exists($serviceClass)) {

            // Create a new instance with arguments
            $request = new $serviceClass(...$arguments);
            $method = $request->getMethode();
            $url = 'https://api-v3.igdb.com/' . $request->getUrl() . '/';
            $param = $request->getOptions();

            // dd($request);
            try {
                // Call to API
                return $response = $this->client->request($method,  $url , $param);

            } catch (ClientException $e) {
                // Throw exception
                throw new \Exception('Service ' . $name . ' failed because ' . $e->getMessage());
            }
        }

        // Throw exception if the Service class does not exist
        throw new \Exception('Service ' . $name . ' does not defined.');
    }
}
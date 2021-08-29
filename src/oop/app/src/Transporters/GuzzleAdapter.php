<?php

namespace src\oop\app\src\Transporters;

use GuzzleHttp\Client;

class GuzzleAdapter implements TransportInterface
{
    private $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    /**
     * @param string $url
     * @return string
     */
    public function getContent(string $url): string
    {
        $res = $this->guzzleClient->request('GET', $url);

        return $res->getBody()->getContents();
    }
}
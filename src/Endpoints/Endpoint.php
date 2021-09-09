<?php namespace Pkge\Endpoints;

use Pkge\Common\HttpClient;

/**
 * Base Endpoint class
 * @package Pkge\Endpoints
 */
abstract class Endpoint
{
    protected $client;

    /**
     * Endpoint constructor.
     * @param \Pkge\Common\HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->client = $httpClient;
    }
}
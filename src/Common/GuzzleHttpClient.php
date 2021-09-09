<?php namespace Pkge\Common;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\RequestOptions;
use Pkge\Exceptions\ApiRequestException;
use Pkge\Exceptions\ApiRequestValidationException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient extends HttpClient
{
    /** @var \GuzzleHttp\Client */
    private $instance;

    public function __construct($apiKey, $language = null, $expandRelatedObjects = false)
    {
        parent::__construct($apiKey, $language, $expandRelatedObjects);

        $stack = HandlerStack::create();

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
            return $request
                ->withHeader('X-Api-Key', $this->apiKey)
                ->withHeader('X-Api-Expand-Related-Objects', $this->expandRelatedObjects ? 'true' : 'false')
                ->withHeader('Accept-Language', $this->language);
        }));

        $stack->push(Middleware::mapResponse(function (ResponseInterface $response) {
            $this->_lastResponseMetaData = new ResponseMetaData($response);

            $jsonResponse = json_decode($response->getBody()->getContents(), true);

            if ($response->getStatusCode() === 422) {
                throw new ApiRequestValidationException($jsonResponse['payload']['errors'], 422);
            }
            elseif ($response->getStatusCode() >= 400) {
                if (isset($this->exceptionsMapping[$jsonResponse['code']])) {
                    throw new $this->exceptionsMapping[$jsonResponse['code']]($jsonResponse['payload'], $jsonResponse['code']);
                }

                throw new ApiRequestException($jsonResponse['payload'], $jsonResponse['code']);
            }

            $body = Utils::streamFor(json_encode($jsonResponse['payload']));
            return $response->withBody($body);
        }));

        $this->instance = new Client([
            RequestOptions::HTTP_ERRORS => false,
            'base_uri' => self::API_URL,
            'handler' => $stack,
        ]);
    }

    public function sendRequest($request, $options = [])
    {
        $payload = $this->instance->send($request, $options);
        return json_decode($payload->getBody()->getContents(), true);
    }
}
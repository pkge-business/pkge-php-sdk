<?php namespace Pkge;

use Pkge\Common\BaseObject;
use Pkge\Common\GuzzleHttpClient;
use Pkge\Endpoints\Couriers;
use Pkge\Endpoints\Packages;

/**
 * API endpoints wrapper
 * @package Pkge
 * @property-read \Pkge\Endpoints\Couriers $couriers Couriers endpoints
 * @property-read \Pkge\Endpoints\Packages $packages Packages endpoints
 */
class API extends BaseObject
{
    private $couriersEndpoint;
    private $packagesEndpoint;

    private $httpClient;

    public function __construct($apiKey, $language = 'en', $expandRelatedObjects = false)
    {
        $this->httpClient = new GuzzleHttpClient(
            $apiKey,
            $language,
            $expandRelatedObjects
        );

        $this->couriersEndpoint = new Couriers($this->httpClient);
        $this->packagesEndpoint = new Packages($this->httpClient);
    }

    /**
     * @param mixed|null $language
     */
    public function setLanguage($language)
    {
        $this->httpClient->setLanguage($language);
    }

    /**
     * @return \Pkge\Common\ResponseMetaData
     */
    public function getLastResponseMetaData()
    {
        return $this->httpClient->getLastResponseMetaData();
    }

    public function __get($name)
    {
        $propertyName = $name . 'Endpoint';
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        throw new \Exception('Getting unknown property: ' . get_class($this) . '::' . $name);
    }
}
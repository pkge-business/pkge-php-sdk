<?php namespace Pkge\Common;


/**
 * Class HttpClient
 * @package Pkge\Common
 *
 * @property-read string $apiKey
 * @property-read string $language
 * @property-read bool $expandRelatedObjects
 */
abstract class HttpClient
{
    const API_URL = 'https://api.pkge.net/v1/';

    protected $apiKey;
    protected $language;
    protected $expandRelatedObjects = false;

    protected $_lastResponseMetaData;

    protected $exceptionsMapping = [
        401 => '\Pkge\Exceptions\ApiBadKeyException',
        429 => '\Pkge\Exceptions\ApiRequestRateLimitException',
        900 => '\Pkge\Exceptions\ApiWrongTrackNumberException',
        901 => '\Pkge\Exceptions\ApiWrongCourierIdException',
        902 => '\Pkge\Exceptions\ApiTrackNumberExistsException',
        903 => '\Pkge\Exceptions\ApiPackageCannotBeUpdatedException',
        904 => '\Pkge\Exceptions\ApiCouriersNotDetectedException',
        905 => '\Pkge\Exceptions\ApiPackagesLimitExceededException',
        909 => '\Pkge\Exceptions\ApiMaxPackagesAmountUpdatingNowException'
    ];

    public function __construct($apiKey, $language = null, $expandRelatedObjects = false)
    {
        $this->apiKey = $apiKey;
        $this->language = $language;
        $this->expandRelatedObjects = $expandRelatedObjects;
    }

    /**
     * @param mixed|null $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return \Pkge\Common\ResponseMetaData
     */
    public function getLastResponseMetaData()
    {
        return $this->_lastResponseMetaData;
    }

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     * @param array $options
     * @return array|bool
     * @throws \Pkge\Exceptions\ApiRequestException
     * @throws \Pkge\Exceptions\ApiRequestValidationException
     */
    abstract public function sendRequest($request, $options = []);
}
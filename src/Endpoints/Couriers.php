<?php namespace Pkge\Endpoints;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Pkge\Entities\Courier;

/**
 * Couriers API endpoints wrapper
 * @package Pkge\Endpoints
 */
class Couriers extends Endpoint
{
    /**
     * Enable courier
     * @param $courierId
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function enable($courierId)
    {
        $this->client->sendRequest(
            new Request('POST', 'couriers/enable'), [
                RequestOptions::QUERY => [
                    'id' => $courierId
                ]
            ]
        );
    }

    /**
     * Disable courier
     * @param $courierId
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function disable($courierId)
    {
        $this->client->sendRequest(
            new Request('POST', 'couriers/disable'), [
                RequestOptions::QUERY => [
                    'id' => $courierId
                ]
            ]
        );
    }

    /**
     * List of all available delivery services
     * [For details see](https://business.pkge.net/docs/couriers/list)
     * @return \Pkge\Entities\Courier[]
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function getAll()
    {
        return Courier::mapArrayFromJson(
            $this->client->sendRequest(
                new Request('GET', 'couriers')
            )
        );
    }

    /**
     * List of enabled delivery services
     * [For details see](https://business.pkge.net/docs/couriers/list)
     * @return \Pkge\Entities\Courier[]
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function getEnabled()
    {
        return Courier::mapArrayFromJson(
            $this->client->sendRequest(
                new Request('GET', 'couriers/enabled')
            )
        );
    }

    /**
     * Detect delivery service for a tracking number
     * [For details see](https://business.pkge.net/docs/couriers/detect)
     * @param $trackNumber
     * @return \Pkge\Entities\Courier[]
     * @throws \Pkge\Exceptions\ApiRequestException
     * @throws \Pkge\Exceptions\ApiPackagesLimitExceededException
     * @throws \Pkge\Exceptions\ApiWrongTrackNumberException
     * @throws \Pkge\Exceptions\ApiCouriersNotDetectedException
     */
    public function detectForTrackNumber($trackNumber)
    {
        $response = $this->client->sendRequest(
            new Request('GET', 'couriers/detect'), [
                RequestOptions::QUERY => [
                    'trackNumber' => $trackNumber
                ]
            ]
        );

        return Courier::mapArrayFromJson($response);
    }
}
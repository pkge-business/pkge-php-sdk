<?php namespace Pkge\Endpoints;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Pkge\Endpoints\DTO\PackageUpdatingStatus;
use Pkge\Entities\Package;

/**
 * Packages API endpoints wrapper
 * @package Pkge\Endpoints
 */
class Packages extends Endpoint
{
    /**
     * Get package info
     * @param string $trackNumber Package tracking number
     * [For details see](https://business.pkge.net/docs/packages/get)
     * @return \Pkge\Entities\Package
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function get($trackNumber)
    {
        $response = $this->client->sendRequest(
            new Request('GET', 'packages'), [
                RequestOptions::QUERY => [
                    'trackNumber' => $trackNumber
                ]
            ]
        );

        return new Package($response);
    }

    /**
     * Get list of packages
     * @param array $filters params for filtering packages
     * @param int $page Page number: starting with 1 (default 1)
     * @param int $perPage Number of objects per page: from 20 to 100 (default 20)
     * [For details see](https://business.pkge.net/docs/packages/list)
     * @return \Pkge\Entities\Package[]
     * @throws \Pkge\Exceptions\ApiRequestException
     * @throws \Pkge\Exceptions\ApiRequestValidationException
     */
    public function getAll(array $filters = [], $page = 1, $perPage = 20)
    {
        $response = $this->client->sendRequest(
            new Request('GET', 'packages/list'), [
                RequestOptions::QUERY => array_merge($filters, [
                    'page' => $page,
                    'per-page' => $perPage
                ])
            ]
        );

        return Package::mapArrayFromJson($response);
    }

    /**
     * Adding package
     * @param string $trackNumber Package tracking number
     * @param Int $courierId Delivery service digital ID. To automatically identify the delivery service, send the value -1.
     * When a delivery service is automatically identified, 1/5 of the package cost will be deducted from your plan's package
     * limit for each delivery service identification request. So, if you add 5 packages with automatic delivery service identification,
     * your plan package limit will be reduced by 6 packages: 5 packages added + 1 package for 5 automatic delivery service identifications.
     * @param array $data Optional POST request parameters.
     * [For details see](https://business.pkge.net/docs/packages/add)
     * @return \Pkge\Entities\Package
     * @throws \Pkge\Exceptions\ApiRequestValidationException
     * @throws \Pkge\Exceptions\ApiPackagesLimitExceededException
     * @throws \Pkge\Exceptions\ApiTrackNumberExistsException
     * @throws \Pkge\Exceptions\ApiWrongTrackNumberException
     * @throws \Pkge\Exceptions\ApiWrongCourierIdException
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function add($trackNumber, $courierId, array $data = [])
    {
        $response = $this->client->sendRequest(
            new Request('POST', 'packages'), [
                RequestOptions::QUERY => [
                    'trackNumber' => $trackNumber,
                    'courierId' => $courierId
                ],
                RequestOptions::FORM_PARAMS => $data
            ]
        );

        return new Package($response);
    }

    /**
     * Starting package update process
     * @param string $trackNumber Package tracking number
     * [For details see](https://business.pkge.net/docs/packages/update)
     * @return PackageUpdatingStatus
     * @throws \Pkge\Exceptions\ApiMaxPackagesAmountUpdatingNowException
     * @throws \Pkge\Exceptions\ApiPackageCannotBeUpdatedException
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function update($trackNumber)
    {
        $response = $this->client->sendRequest(
            new Request('POST', 'packages/update'), [
                RequestOptions::QUERY => [
                    'trackNumber' => $trackNumber
                ]
            ]
        );

        return new PackageUpdatingStatus($response);
    }

    /**
     * Check package update progress
     * @param string $trackNumber Package tracking number
     * @param string $hash Hash of the current package state information
     * obtained at the first update step
     * [For details see](https://business.pkge.net/docs/packages/update)
     * @return \Pkge\Endpoints\DTO\PackageUpdatingStatus
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function getUpdatingStatus($trackNumber, $hash)
    {
        $response = $this->client->sendRequest(
            new Request('GET', 'packages/updating-status'), [
                RequestOptions::QUERY => [
                    'trackNumber' => $trackNumber,
                    'hash' => $hash
                ]
            ]
        );

        if ($response['hash'] !== $hash) {
            return new PackageUpdatingStatus(
                $response['hash'],
                $response['updating'],
                $response['package']
            );
        }

        return new PackageUpdatingStatus($response['hash']);
    }

    /**
     * Edit package info
     * @param string $trackNumber Package tracking number
     * @param array $data Optional POST request parameters.
     * [For details see](https://business.pkge.net/docs/packages/edit)
     * @return \Pkge\Entities\Package
     * @throws \Pkge\Exceptions\ApiRequestValidationException
     * @throws \Pkge\Exceptions\ApiRequestException
     */
    public function edit($trackNumber, array $data = [])
    {
        $response = $this->client->sendRequest(
            new Request('PUT', 'packages'), [
                RequestOptions::QUERY => [
                    'trackNumber' => $trackNumber
                ],
                RequestOptions::FORM_PARAMS => $data
            ]
        );

        return new Package($response);
    }

    /**
     * Deleting a package
     * @param string $trackNumber Package tracking number
     * [For details see](https://business.pkge.net/docs/packages/delete)
     * @return bool true if a package is successfully deleted,
     * otherwise @throws \Pkge\Exceptions\ApiRequestException
     */
    public function delete($trackNumber)
    {
        return $this->client->sendRequest(
            new Request('DELETE', 'packages'), [
            RequestOptions::QUERY => [
                'trackNumber' => $trackNumber
            ]
        ]);
    }
}
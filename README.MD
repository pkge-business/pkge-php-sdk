![logo](logo.svg)
## Pkge.net Business API PHP SDK
Library provides convenient access to [business.pkge.net](https://business.pkge.net) api for applications written in PHP language.

API documentation are available here: [https://business.pkge.net/docs](https://business.pkge.net/docs)
## Requirements

PHP 5.4.0 and later.

## Installation
#### Via Composer (https://getcomposer.org/)

Run the following command:

```bash
composer require pkge/php-sdk
```
To use SDK, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Getting Started
First, you need initialize api wrapper class with your api key
```php
$api = new \Pkge\API(
    '{API_KEY}', //Your API key
    'en', //API language
    false //Expand related objects
);
```

## Responses Metadata

Metadata for last response, such as requests [rate-limiting](src/Common/ResponseRateLimit.php) and [pagination](src/Common/ResponsePagination.php) information for some API endpoints, available in `getLastResponseMetaData()` method:
```php
$metadata = $api->getLastResponseMetaData();

//Last response status code
$metadata->responseStatusCode; 

//Requests Rate-Limit information.
$metadata->rateLimit;

//Pagination information
$metadata->pagination;
```

## Entities

All entities used in the SDK and descriptions of their properties, see in [/src/Entities](src/Entities)

## Delivery services endpoints

Access to all delivery services endpoints via `couriers` property of API object:
```php
$api->couriers;
```
All available endpoints methods see in [\Pkge\Endpoints\Couriers::class](src/Endpoints/Couriers.php)

## Packages endpoints

Access to all delivery services endpoints via `packages` property of API object:
```php
$api->packages;
```
All available endpoints methods see in [\Pkge\Endpoints\Packages::class](src/Endpoints/Packages.php)

## Exceptions

In some cases, exceptions may occur when making API requests via the SDK. Their description is given below. For more information about what exceptions a particular method can throw, see the PHPDoc comments on this method.

- `\Pkge\Exceptions\ApiBadKeyException` - Invalid API key specified. How to get API key, see [here](https://business.pkge.net/docs/overview/auth).
- `\Pkge\Exceptions\ApiCouriersNotDetectedException` - Failed to automatically identify the delivery service for the given tracking number.
- `\Pkge\Exceptions\ApiMaxPackagesAmountUpdatingNowException` - Failed to update the package. The maximum number of packages allowed is currently being updated. Wait for the next package to complete the update and repeat the request.
- `\Pkge\Exceptions\ApiPackageCannotBeUpdatedException` -  Failed to update the package. Not enough time has passed since the last update, or the package has already been delivered. Followed by the date of the next possible update in 'payload' if an update is possible.
- `\Pkge\Exceptions\ApiPackagesLimitExceededException` - You've reached your plan's limit for adding packages for the billing period.
- `\Pkge\Exceptions\ApiRequestRateLimitException` - Limit for requests per second exceeded.
- `\Pkge\Exceptions\ApiTrackNumberExistsException` - Tracking number has already been added.
- `\Pkge\Exceptions\ApiWrongCourierIdException` - Invalid delivery service ID specified.
- `\Pkge\Exceptions\ApiWrongTrackNumberException` - Invalid or unsupported tracking number format.
- `\Pkge\Exceptions\ApiRequestValidationException` - Error validating data sent by POST request. See validation errors descriptions in `getValidationErrors()` method of exception.
- `\Pkge\Exceptions\ApiRequestException` - General or unknown request error. For a description, see the `getMessage()`method.

## Example

Example demo code see in [examples/demo.php](examples/demo.php).
Run:
```bash
php ./examples/demo.php
```
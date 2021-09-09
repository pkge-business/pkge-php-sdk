<?php namespace Pkge\Exceptions;

/**
 * Failed to update the package. The maximum number of packages allowed
 * is currently being updated. Wait for the next package to complete the
 * update and repeat the request
 * @package Pkge\Exceptions
 */
class ApiMaxPackagesAmountUpdatingNowException extends ApiRequestException
{

}
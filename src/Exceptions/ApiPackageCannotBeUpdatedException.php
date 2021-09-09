<?php namespace Pkge\Exceptions;

/**
 * Failed to update the package. Not enough time has passed since the last update,
 * or the package has already been delivered. Followed by the date of the next possible
 * update in 'payload' if an update is possible
 * Class ApiPackageCannotBeUpdatedException
 * @package Pkge\Exceptions
 */
class ApiPackageCannotBeUpdatedException extends ApiRequestException
{

}
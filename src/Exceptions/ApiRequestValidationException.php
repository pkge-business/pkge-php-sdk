<?php namespace Pkge\Exceptions;

/**
 * Error validating data sent by POST request
 * @package Pkge\Exceptions
 */
class ApiRequestValidationException extends ApiRequestException
{
    private $errors;

    public function __construct($errors = [], $code = 0, $previous = null)
    {
        $this->errors = $errors;
        parent::__construct('API validation exception', $code, $previous);
    }

    /**
     * Array with list of validation errors
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->errors;
    }
}
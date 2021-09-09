<?php namespace Pkge\Common;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseMetaData
 * @package Pkge\Common
 *
 * @property-read int $responseStatusCode Last response status code
 * @property-read \Pkge\Common\ResponsePagination|false $pagination Meta-data about objects pagination
 * @property-read \Pkge\Common\ResponseRateLimit|false $rateLimit Meta-data about requests rate-limit
 */
class ResponseMetaData extends BaseObject
{
    protected $responseStatusCode;
    protected $pagination = false;
    protected $rateLimit = false;

    public function __construct(ResponseInterface $response)
    {
        $this->responseStatusCode = $response->getStatusCode();
        if ($response->getHeader('X-Rate-Limit-Limit')) {
            $this->rateLimit = new ResponseRateLimit($response);
        }

        if ($response->getHeader('X-Pagination-Total-Count')) {
            $this->pagination = new ResponsePagination($response);
        }
    }
}
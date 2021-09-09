<?php namespace Pkge\Common;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseRateLimit
 * @package Pkge\Common
 *
 * @property-read int $limit Maximum number of requests allowed during the period.
 * @property-read int $remaining Remaining number of allowed requests in the current time period.
 * @property-read int $reset Number of seconds to wait before getting the maximum number of allowed requests.
 */
class ResponseRateLimit extends BaseObject
{
    protected $limit;
    protected $remaining;
    protected $reset;

    public function __construct(ResponseInterface $response)
    {
        $this->limit = $response->getHeader('X-Rate-Limit-Limit')[0];
        $this->remaining = $response->getHeader('X-Rate-Limit-Remaining')[0];
        $this->reset = $response->getHeader('X-Rate-Limit-Reset')[0];
    }
}
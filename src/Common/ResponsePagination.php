<?php namespace Pkge\Common;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponsePagination
 * @package Pkge\Common
 *
 * @property-read int $totalCount Total number of objects in the results on all pages
 * @property-read int $pageCount Number of pages
 * @property-read int $currentPage Current page (starting with 1)
 * @property-read int $perPage Number of objects per page
 */
class ResponsePagination extends BaseObject
{
    protected $totalCount;
    protected $pageCount;
    protected $currentPage;
    protected $perPage;

    public function __construct(ResponseInterface $response)
    {
        $this->totalCount = $response->getHeader('X-Pagination-Total-Count')[0];
        $this->pageCount = $response->getHeader('X-Pagination-Page-Count')[0];
        $this->currentPage = $response->getHeader('X-Pagination-Current-Page')[0];
        $this->perPage = $response->getHeader('X-Pagination-Per-Page')[0];
    }
}
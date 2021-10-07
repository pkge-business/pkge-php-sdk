<?php namespace Pkge\Entities\Webhooks;

use Pkge\Entities\Package;

/**
 * Class Event
 * @package Pkge\Entities\Webhooks
 *
 * @property-read string $id Webhook event unique ID
 * @property-read string $type Event identifier
 * @property-read int $timestamp UNIX-timestamp of event sending time
 * @property-read \Pkge\Entities\Package $payload Event entity payload
 */
class Event extends \Pkge\Entities\Entity
{
    /** Package webhook events */
    const PACKAGE_INFO_RECEIVED = 'package.info_received';
    const PACKAGE_IN_TRANSIT = 'package.in_transit';
    const PACKAGE_DELIVERED = 'package.delivered';
    const PACKAGE_HANDED = 'package.handed';
    const PACKAGE_DELIVERY_FAILED = 'package.delivery_failed';

    protected $id;
    protected $type;
    protected $timestamp;
    protected $payload;

    public function __construct($fromJson = null)
    {
        parent::__construct($fromJson);

        $this->payload = new Package($this->payload);
    }
}
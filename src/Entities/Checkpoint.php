<?php namespace Pkge\Entities;

/**
 * Class Checkpoint
 * @package Pkge\Entities
 *
 * @property-read string|null $id Unique checkpoint ID. Can be null in cases where it's a
 * standard checkpoint stub when no checkpoints have been received from any delivery service
 * @property-read string $date Date and time package was added. ISO-8601
 * @property-read string $title Checkpoint description
 * @property-read string $location Package location at the time of checkpoint receipt from the delivery service
 * @property-read float $latitude The geographic latitude of the package's location at the time of checkpoint
 * receipt from the delivery service
 * @property-read float $longitude The geographic longitude of the package's location at the time
 * of checkpoint receipt from the delivery service
 * @property-read int|null $courierId ID of the delivery service currently delivering the package
 * @property-read \Pkge\Entities\Courier|null Delivery service currently delivering the package
 */
class Checkpoint extends Entity
{
    protected $id;
    protected $date;
    protected $title;
    protected $location;
    protected $latitude;
    protected $longitude;
    protected $courierId;
    protected $courier;
}
<?php namespace Pkge\Entities;

/**
 * Class Package
 * @package Pkge\Entities
 *
 * @property-read string $trackNumber Package tracking number
 * @property-read string $createdAt Date and time package was added. ISO 8601
 * @property-read string|null $lastTrackingDate Date and time of last package info update. ISO 8601.
 * The null value is possible if the package hasn't been updated yet
 * @property-read string|null $origin Package sender's address
 * @property-read string|null $destination Package destination address
 * @property-read string $lastStatus Status description from the last package checkpoint
 * @property-read string $lastStatusDate Date of last checkpoint. ISO 8601
 * @property-read int $status Package status ID
 * @property-read \Pkge\Entities\Checkpoint[]|null $checkpoints List of all package checkpoints
 * @property-read string|null $estDeliveryDateFrom Estimated initial
 * (or exact, if the value "estDeliveryDateTo" is null) package delivery date. ISO 8601
 * @property-read string|null $estDeliveryDateTo Estimated package delivery date. ISO 8601
 * @property-read string[] $extraTrackNumbers List of additional package tracking numbers
 * @property-read string $hash Hash of the current package information.
 * Read more in the Updating package information section
 * @property-read string|null $consolidatedTrackNumber Consolidated package number
 * @property-read string|null $consolidationDate Package consolidation date. ISO 8601
 * @property-read string $destinationCountryCode ISO 3166-1 alpha-2 package destination country code.
 * @property-read bool $updating Flag indicating whether the package information is currently being updated
 * @property-read int $daysOnWay Number of days the package has currently been in transit.
 * Or the number of days from the when tracking began to delivery if the package has already been delivered
 * @property-read string|null $weight Package weight
 * @property-read array $extraInfo Additional package info
 * @property-read array $info Additional package info
 * @property-read int[] $couriersIds List of IDs for delivery service that delivered
 * a package during the whole tracking period
 * @property-read int|null $courierId ID of the delivery service currently delivering the package
 * @property-read \Pkge\Entities\Courier[]|null $couriers List of delivery services that delivered a package
 * during the whole tracking period
 * @property-read \Pkge\Entities\Courier|null $courier Delivery service currently delivering the package
 */
class Package extends Entity
{
    protected $trackNumber;
    protected $createdAt;
    protected $lastTrackingDate;
    protected $origin;
    protected $destination;
    protected $lastStatus;
    protected $lastStatusDate;
    protected $status;
    protected $checkpoints;
    protected $estDeliveryDateFrom;
    protected $estDeliveryDateTo;
    protected $extraTrackNumbers;
    protected $hash;
    protected $consolidatedTrackNumber;
    protected $consolidationDate;
    protected $destinationCountryCode;
    protected $updating;
    protected $daysOnWay;
    protected $weight;
    protected $extraInfo;
    protected $info;
    protected $couriersIds;
    protected $courierId;
    protected $couriers;
    protected $courier;

    /**
     * Package constructor.
     * @param null|array $fromJson
     */
    public function __construct($fromJson = null)
    {
        parent::__construct($fromJson);

        //Map courier into entity
        if ($this->courier) {
            $this->courier = new Courier($this->courier);
        }

        //Map checkpoints array into entities
        if ($this->checkpoints) {
            $this->checkpoints = array_map(static function ($checkpoint) {
                return new Checkpoint($checkpoint);
            }, $this->checkpoints);
        }

        //Map couriers array into entities
        if ($this->couriers) {
            $this->couriers = array_map(static function ($courier) {
                return new Courier($courier);
            }, $this->couriers);
        }
    }
}
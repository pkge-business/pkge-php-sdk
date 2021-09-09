<?php namespace Pkge\Endpoints\DTO;

use Pkge\Common\BaseObject;
use Pkge\Entities\Package;

/**
 * Class PackageUpdatingStatus
 * @package Pkge\Endpoints\DTO
 * @property-read string $hash A hash of the package information's current status
 * @property-read bool $isUpdating Flag indicating whether the package information is currently being updated
 * @property-read Package|null $package Object of the currently updated package
 */
class PackageUpdatingStatus extends BaseObject
{
    protected $hash;
    protected $isUpdating = false;
    protected $package = null;

    public function __construct($hash, $isUpdating = true, $package = null)
    {
        $this->hash = $hash;
        $this->isUpdating = $isUpdating;

        if (!is_null($package)) {
            $this->package = new Package($package);
        }
    }
}
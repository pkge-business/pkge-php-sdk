<?php namespace Pkge\Entities;

use Pkge\Entities\ExtraFields\DropDownExtraField;
use Pkge\Entities\ExtraFields\TextExtraField;

/**
 * Class Courier
 * @package Pkge\Entities
 *
 * @property-read int $id Delivery service digital ID
 * @property-read string $slug Standard Carrier Alpha Code (SCAC)
 * @property-read string $name Delivery service name
 * @property-read string $logo Delivery service logo URL
 * @property-read string $websiteLink Delivery service website URL
 * @property-read \Pkge\Entities\ExtraFields\TextExtraField[]|DropDownExtraField[] $extraFields List of additional fields
 * whose values must be provided when adding a package to track it with this delivery service
 */
class Courier extends Entity
{
    protected $id;
    protected $slug;
    protected $name;
    protected $logo;
    protected $websiteLink;
    protected $extraFields;

    /**
     * Courier constructor.
     * @param null|array $fromJson
     */
    public function __construct($fromJson = null)
    {
        parent::__construct($fromJson);

        foreach ($this->extraFields as $k => &$extraField) {
            if ($extraField['type'] === 'text') {
                $extraField = new TextExtraField($extraField);
            }
            elseif ($extraField['type'] === 'dropdown') {
                $extraField = new DropDownExtraField($extraField);
            }
            else {
                unset ($this->extraFields[$k]);
            }
        }
    }
}
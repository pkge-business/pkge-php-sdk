<?php namespace Pkge\Entities\ExtraFields;

use Pkge\Entities\Entity;

/**
 * Class TextExtraField
 * @package Pkge\Entities\ExtraFields
 *
 * @property-read string $name The name of the POST parameter where you must send
 * the value when adding a package. It varies depending on the delivery service and
 * field mapping. The current list of additional fields for each delivery service can
 * be obtained from the API list of delivery services.
 * @property-read string $placeholder A description of the required additional
 * information that should be provided in this field.
 * @property-read string $fieldRegexp A regular expression used to check if this field
 * is required to get information from the delivery service. If the tracking number matches
 * this regular expression, the field is required.
 * @property-read string $values List of available values and their descriptions.
 */
class TextExtraField extends Entity
{
    protected $name;
    protected $placeholder;
    protected $fieldRegexp;
    protected $validateRegexp;
}
<?php namespace Pkge\Entities;

use Pkge\Common\BaseObject;

abstract class Entity extends BaseObject
{
    private $_rawData;

    /**
     * Entity constructor.
     * @param null|array $fromJson
     */
    public function __construct($fromJson = null)
    {
        if (is_array($fromJson)) {
            foreach ($fromJson as $key => $value) {
                $key = self::camelize($key);
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }

        $this->_rawData = $fromJson;
    }

    /**
     * @param $string
     * @return string
     */
    private static function camelize($string)
    {
        return lcfirst(str_replace('_', '', ucwords($string, '_')));
    }

    /**
     * @param array $json
     * @return static[]
     */
    public static function mapArrayFromJson($json)
    {
        return array_map(static function ($jsonEntity) {
            return new static($jsonEntity);
        }, $json);
    }

    /**
     * @return array|null
     */
    public function getRawData()
    {
        return $this->_rawData;
    }
}
<?php namespace Pkge\Common;

/**
 * Class BaseObject
 * @package Pkge\Common
 */
abstract class BaseObject
{
    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new \Exception('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        throw new \Exception('Setting read-only property: ' . get_class($this) . '::' . $name);
    }

    public function __isset($name)
    {
        return isset($this->{$name});
    }

}
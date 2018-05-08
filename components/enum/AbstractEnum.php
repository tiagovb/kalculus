<?php

namespace app\components\enum;

/**
 * Class AbstractEnum
 */
abstract class AbstractEnum
{
    /* @var array */
    public static $listEnumLabels = [];

    /**
     * Returns all class constants
     *
     * @return array
     */
    public static function getEnumList()
    {
        $reflection = new \ReflectionClass(get_called_class());
        $constants = $reflection->getConstants();

        return $constants;
    }

    /**
     * Returns all constants as value => label
     *
     * @return array
     */
    public static function getEnumListLabels()
    {
        return static::$listEnumLabels;
    }

    /**
     * Converts a string value of a constant (or any value) into a more
     * human-readable format
     *
     * @param string $constant
     *
     * @return string
     */
    public static function getEnumLabel($constant)
    {
        return static::$listEnumLabels[$constant];
    }
}

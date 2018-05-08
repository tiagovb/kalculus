<?php

namespace app\components\interfaces;

/**
 * Interface EnumInterface
 */
interface EnumInterface
{
    /**
     * @param $enum
     *
     * @return mixed
     */
    public static function getEnumListLabels($enum);

    /**
     * @param $enum
     * @param $constant
     *
     * @return mixed
     */
    public static function getEnumLabel($enum, $constant);
}

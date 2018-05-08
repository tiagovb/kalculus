<?php

namespace app\components\traits;

use yii\base\InvalidParamException;

/**
 * Class EnumTrait
 *
 * @property mixed $listEnumLabels
 */
trait EnumTrait
{
    /**
     * Retorna todas as constantes no formato value => label
     *
     * @param string $enum O tipo de enum
     *
     * @return array
     */
    public static function getEnumListLabels($enum)
    {
        self::validateEnum($enum);

        return static::$listEnumLabels[$enum];
    }

    /**
     * Retorna todos os valores possíveis de um ENUM
     *
     * @param string $enum O tipo de enum
     *
     * @return array
     */
    public static function getEnumList($enum)
    {
        return array_keys(self::getEnumListLabels($enum));
    }

    /**
     * Retorna o label de determinado valor
     *
     * @param $enum
     * @param string $constant
     *
     * @return string
     */
    public static function getEnumLabel($enum, $constant)
    {
        self::validateEnum($enum);

        if (isset(static::$listEnumLabels[$enum][$constant])) {
            return static::$listEnumLabels[$enum][$constant];
        }

        return $constant;
    }

    /**
     * Validar se o enum informado é válido e foi declarado
     *
     * @param $enum
     */
    private static function validateEnum($enum)
    {
        if (!isset(self::$listEnumLabels) || !isset(self::$listEnumLabels[$enum])) {
            throw new InvalidParamException("A propriedade \$listEnumLabels['{$enum}'] não foi declarada.");
        }
    }
}

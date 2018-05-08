<?php

namespace app\components\validators;

use yii\validators\RegularExpressionValidator;

/**
 * Class CepValidator
 */
class CepValidator extends RegularExpressionValidator
{
    /**
     * @inheritdoc
     */
    public $pattern = '/^[0-9]{5}-?[0-9]{3}$/';

    /**
     * @inheritdoc
     */
    public $enableClientValidation = false;
}

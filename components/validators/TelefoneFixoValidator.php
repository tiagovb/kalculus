<?php

namespace app\components\validators;

use yii\validators\RegularExpressionValidator;

/**
 * Class TelefoneFixoValidator
 */
class TelefoneFixoValidator extends RegularExpressionValidator
{
    /**
     * @inheritdoc
     */
    public $pattern = '/^\(?[1-9]{2}\)? ?[2-5]\d{3}-?\d{4}$/';
}

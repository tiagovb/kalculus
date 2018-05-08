<?php

namespace app\components\validators;

use yii\validators\RegularExpressionValidator;

/**
 * Class DataNascimentoValidator
 */
class DataNascimentoValidator extends RegularExpressionValidator
{
    /**
     * @inheritdoc
     */
    public $pattern = '/^([0-2][0-9]|3[0-1])\/([0][0-9]|1[0-2])\/(19|20)[0-9]{2}$/';

    /**
     * @inheritdoc
     */
    public $message = 'Data de nascimento inválida';

    /**
     * @inheritdoc
     */
    public $enableClientValidation = true;
}

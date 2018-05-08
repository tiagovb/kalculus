<?php

namespace app\components\validators;

use Yii;
use yii\validators\RegularExpressionValidator;

class NoSpaceValidator extends RegularExpressionValidator
{
    public $pattern = '/\s/';

    public $not = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->message = Yii::t('app', '"{attribute}" não pode conter espaços');

        parent::init();
    }
}

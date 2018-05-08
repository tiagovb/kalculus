<?php

namespace app\components\validators;

use Yii;
use yii\validators\RegularExpressionValidator;

/**
 * Class CelularValidator
 */
class CelularValidator extends RegularExpressionValidator
{
    /**
     * @inheritdoc
     */
    public $pattern = '/^(\(?[0]?[1-9][0-9]\)?)(\.|\-|\s)?([9]{1})?[0-9]{4}(\.|\-|\s)?[0-9]{4}$/';

    /**
     * @inheritDoc
     */
    public function init()
    {
        if ($this->message === null) {
            $this->message = Yii::t('yii', 'Por favor, informe um número de celular válido.');
        }

        parent::init();
    }
}

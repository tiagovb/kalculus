<?php

namespace app\helpers;

use kartik\form\ActiveForm as yActiveForm;

/**
 * @method ActiveField|ActiveField field($model, $attribute, $options = [])
 */
class ActiveForm extends yActiveForm
{
    /**
     * @inheritdoc
     */
    public $validateOnType = true;

    public function init()
    {
        $this->fieldClass = ActiveField::className();
        $this->fieldConfig = ['class' => ActiveField::className()];
        parent::init();
    }
}

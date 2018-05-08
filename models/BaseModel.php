<?php

namespace app\models;


abstract class BaseModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function delete()
    {
        if (!$this->canDelete()) {
            return false;
        }

        return parent::delete();
    }

    abstract public function canDelete();
}

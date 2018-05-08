<?php

namespace app\components;

use app\components\enum\EnumBoolSimNao;
use Yii;

/**
 * @inheritdoc
 */
class Formatter extends \yii\i18n\Formatter
{
    public $defaultTimeZone = 'America/Sao_Paulo';
    public $timeZone = 'America/Sao_Paulo';
    public $nullDisplay = '-';

    /**
     * @param $value
     *
     * @return string
     */
    public function asLabelBoolean($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        $enum = EnumBoolSimNao::getEnumListLabels();

        if (isset($enum[$value])) {
            if ((int)$value === EnumBoolSimNao::BOOL_SIM) {
                return '<span class="label label-success label-sm">' . Yii::t('app', 'Sim') . '</span>';
            }

            if ((int)$value === EnumBoolSimNao::BOOL_NAO) {
                return '<span class="label label-danger label-sm">' . Yii::t('app', 'Não') . '</span>';
            }
        }

        return '<span class="label label-default label-sm">' . $value . '</span>';
    }
}

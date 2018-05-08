<?php

namespace app\helpers;

use app\models\BaseModel;
use kartik\grid\ActionColumn as KartikActionColumn;

class ActionColumn extends KartikActionColumn
{

    public $hiddenFromExport = true;

    public $headerOptions = ['style' => 'font-size:90%;'];

    public $contentOptions = ['style' => ['white-space' => 'nowrap'], 'class' => 'actions-column'];

    public function init()
    {
        $this->visibleButtons = [
            'delete' => function ($model) {
                /** @var BaseModel $model */
                return $model->canDelete();
            },
        ];

        parent::init();
    }
}

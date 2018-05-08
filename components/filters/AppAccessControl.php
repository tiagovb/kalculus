<?php

namespace app\components\filters;

use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * Class AppAccessControl
 */
class AppAccessControl extends AccessControl
{
    /**
     * @inheritdoc
     */
    public $except = [
        'user/*',
        'debug/*',
        'gii/*',
    ];

    /**
     * @inheritdoc
     * @throws \yii\web\ForbiddenHttpException
     */
    public function init()
    {
        $this->denyCallback = function () {
            if ($this->user->getIsGuest()) {
                $this->user->loginRequired();
            } else {
                throw new ForbiddenHttpException();
            }
        };

        $this->rules = [
            [
                'allow' => true,
                'roles' => ['@'],
                'controllers' => [
                    'site',
                    'pessoa',
                    'gridview/*',
                ],
            ],
        ];

        parent::init();
    }
}

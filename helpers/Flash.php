<?php

namespace app\components;

use Yii;
use yii\web\Session;

/**
 * Class Session
 */
class Flash extends Session
{
    /**
     * @param mixed $value flash message
     */
    public static function error($value)
    {
        Yii::$app->getSession()->setFlash('error', Yii::t('app', $value));
    }

    /**
     * @param mixed $value flash message
     */
    public static function warning($value)
    {
        Yii::$app->getSession()->setFlash('warning', Yii::t('app', $value));
    }

    /**
     * @param mixed $value flash message
     */
    public static function success($value)
    {
        Yii::$app->getSession()->setFlash('success', Yii::t('app', $value));
    }

    /**
     * @param mixed $value flash message
     */
    public static function info($value)
    {
        Yii::$app->getSession()->setFlash('info', Yii::t('app', $value));
    }
}

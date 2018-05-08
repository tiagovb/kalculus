<?php

use kartik\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="notifications-menu">
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <a href="/site/logout" data-method="post">
                            <i class="glyphicon glyphicon-log-out"></i>
                            Sair(<?php echo Yii::$app->user->identity->username; ?>)
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

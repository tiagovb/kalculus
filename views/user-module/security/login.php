<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\LoginForm;
use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'Entrar';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>",
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>",
];
?>

<?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

<?php if ($module->debug): ?>
    <?= $form->field($model, 'login', [
        'inputOptions' => [
            'autofocus' => 'autofocus',
            'class' => 'form-control',
            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
    ?>

<?php else: ?>

    <?= $form->field($model, 'login',
        ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
    );
    ?>

<?php endif ?>

<?php if ($module->debug): ?>
    <div class="alert alert-warning">
        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
    </div>
<?php else: ?>
    <?= $form->field(
        $model,
        'password',
        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])
        ->passwordInput()
        ->label(
            Yii::t('user', 'Password')
            . ($module->enablePasswordRecovery ?
                ' (' . Html::a(
                    Yii::t('user', 'Forgot password?'),
                    ['/user/recovery/request'],
                    ['tabindex' => '5']
                )
                . ')' : '')
        ) ?>
<?php endif ?>

<div class="row">
    <div class="col-xs-8">
        <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
    </div>
    <!-- /.col -->
    <div class="col-xs-4">
        <?= Html::submitButton('Continuar', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
    </div>
    <!-- /.col -->
</div>


<?php ActiveForm::end(); ?>

<div class="social-auth-links text-center">
    <a href="/user/auth?authclient=facebook" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Entrar com Facebook</a>
    <a href="/user/auth?authclient=google" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google"></i> Entrar com Google</a>
</div>

<?php if ($module->enableConfirmation): ?>
    <p class="text-center">
        <?= Html::a(Yii::t('user', 'Didn\'t receive confirmation message?'), ['/user/registration/resend']) ?>
    </p>
<?php endif ?>

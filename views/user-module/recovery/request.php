<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Recover your password');
$this->params['breadcrumbs'][] = $this->title;
?>
<p class="login-box-msg"><?= Html::encode($this->title) ?></p>

<?php $form = ActiveForm::begin(['id' => 'password-recovery-form']); ?>

<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

<?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-primary btn-block']) ?><br>

<?php ActiveForm::end(); ?>

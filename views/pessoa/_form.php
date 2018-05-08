<?php

use kartik\helpers\Html;
use app\helpers\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pessoa */
/* @var $form ActiveForm */
?>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="pessoa-form box box-primary">
            <div class="box-body">
                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'formConfig' => ['labelSpan' => 3]]); ?>
                                            <p class="text-right">
                            <?= Html::a(Html::icon('menu-left') . ' ' . Yii::t('app', 'Voltar'), ['index'], ['class' => 'btn default']) ?>
                        </p>
                        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <hr>                    <?= $this->render('@layouts/_btnFormActions') ?>
                    <?php ActiveForm::end(); ?>

                </div>
        </div>
    </div>
</div>

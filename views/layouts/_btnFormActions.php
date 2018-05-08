<?php

use yii\helpers\Html;

?>

<div class="form-actions text-right">
    <?= Html::submitButton(Yii::t('app', 'Salvar'), ['class' => 'btn btn-success']) ?>
    <?= Html::a(Yii::t('app', 'Cancelar'), ['index'], ['class' => 'btn default']) ?>
</div>

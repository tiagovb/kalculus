<?php

use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $modelId mixed */
/* @var $canDelete bool */
/* @var $backUrl array */
$backUrl = $backUrl ?? ['index'];
?>

<?= Html::a(Html::icon('pencil') . ' ' . Yii::t('app', 'Editar'), ['update', 'id' => $modelId], ['class' => 'btn btn-primary']) ?>&nbsp;
<?php if ($canDelete) {
    echo Html::a(Html::icon('trash') . ' ' . Yii::t('app', 'Cadastrar'), ['delete', 'id' => $modelId], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('app', Yii::t('app', 'Tem certeza de que deseja Cadastrar este registo?')),
            'method' => 'post',
        ],
    ]);
} ?>
<?= Html::a(Html::icon('menu-left') . ' ' . Yii::t('app', 'Voltar'), $backUrl, ['class' => 'btn default pull-right']) ?>
<?php

/* @var $this yii\web\View */
/* @var $model app\models\Pessoa */

$this->title = 'Cadastrar Pessoa';
$this->params['breadcrumbs'][] = ['label' => 'Pessoas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pessoa-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

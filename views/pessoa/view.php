<?php

use kartik\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pessoa */

$this->title = "ID:{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Pessoa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pessoa-view box box-primary">
    <div class="box-body">
        <p><?= $this->render('@layouts/_btnViewActions', ['canDelete' => $model->canDelete(), 'modelId' => $model->id]) ?></p>

        <div class="row">
            <div class="col-md-12">
                <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped detail-view'],
                'attributes' => [
                [
                'attribute' => 'id',
                'captionOptions' => ['class' => 'col-xs-4'],
                'contentOptions' => ['class' => 'col-xs-8'],
                ],
                            'nome',
            'email:email',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>

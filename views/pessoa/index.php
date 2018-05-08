<?php

use app\helpers\ActionColumn;
use kartik\grid\GridView;
use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PessoaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pessoas';
$this->params['breadcrumbs'][] = $this->title;
$gridParams = \app\helpers\IndexGridHelper::gridParams($this, 'Pessoa');
?>
<div class="pessoa-index box box-primary">
    <div class="box-header with-border">
        <div class="box-body table-responsive no-padding">
            
                            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
        'columns' => [

                                    [
 'attribute' => 'id',
                        'format' => 'text',
                        'filter' => Html::activeTextInput($searchModel, 'id', ['class' => 'form-control input-sm']),
                        ],
                    [
 'attribute' => 'nome',
                        'format' => 'text',
                        'filter' => Html::activeTextInput($searchModel, 'nome', ['class' => 'form-control input-sm']),
                        ],
                    [
 'attribute' => 'email',
                        'format' => 'email',
                        'filter' => Html::activeTextInput($searchModel, 'email', ['class' => 'form-control input-sm']),
                        ],

                    [
                        'class' => ActionColumn::class,
                        'hiddenFromExport' => true,
                        'contentOptions' => ['style' => ['white-space' => 'nowrap'],
                    ],
                ],
                ],
                'containerOptions' => $gridParams['containerOptions'],
                'headerRowOptions' => $gridParams['headerRowOptions'],
                'filterRowOptions' => $gridParams['filterRowOptions'],
                'responsiveWrap' => $gridParams['responsiveWrap'],
                'responsive' => $gridParams['responsive'],
                'toolbar' => $gridParams['toolbar'],
                'export' => $gridParams['export'],
                'exportConfig' => $gridParams['exportConfig'],
                'bordered' => $gridParams['bordered'],
                'striped' => $gridParams['striped'],
                'layout' => $gridParams['layout'],
                ]); ?>
                                </div>
    </div>
</div>

<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use app\helpers\ActionColumn;
use kartik\grid\GridView;
use kartik\helpers\Html;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '<?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>';
$this->params['breadcrumbs'][] = $this->title;
$gridParams = \app\helpers\IndexGridHelper::gridParams($this, '<?= StringHelper::basename($generator->modelClass) ?>');
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index box box-primary">
    <div class="box-header with-border">
        <div class="box-body table-responsive no-padding">
            <?= $generator->enablePjax ? "    <?php Pjax::begin(); ?>\n" : '' ?>

            <?php if ($generator->indexWidgetType === 'grid'): ?>
                <?= "<?= " ?>GridView::widget([
                'dataProvider' => $dataProvider,
                <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>

                <?php
                $count = 0;
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        if (++$count < 6) {
                            echo "            '" . $name . "',\n";
                        } else {
                            echo "            //'" . $name . "',\n";
                        }
                    }
                } else {
                    foreach ($tableSchema->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        echo "                    [\n 'attribute' => '{$column->name}',
                        'format' => '{$format}',
                        'filter' => Html::activeTextInput(\$searchModel, '{$column->name}', ['class' => 'form-control input-sm']),
                        ],\n";
                    }
                }
                ?>

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
            <?php else: ?>
                <?= "<?= " ?>ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => function ($model, $key, $index, $widget) {
                return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
                },
                ]) ?>
            <?php endif; ?>
            <?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '' ?>
        </div>
    </div>
</div>

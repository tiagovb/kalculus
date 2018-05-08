<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$idProperty = $generator->modelClass::primaryKey()[0];
echo "<?php\n";
?>

use kartik\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = "ID:{$model-><?= $idProperty ?>}";
$this->params['breadcrumbs'][] = ['label' => '<?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view box box-primary">
    <div class="box-body">
        <p><?= "<?= " ?>$this->render('@layouts/_btnViewActions', ['canDelete' => $model->canDelete(), 'modelId' => $model-><?= $idProperty ?>]) ?></p>

        <div class="row">
            <div class="col-md-12">
                <?= "<?= " ?>DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped detail-view'],
                'attributes' => [
                [
                'attribute' => '<?= $idProperty ?>',
                'captionOptions' => ['class' => 'col-xs-4'],
                'contentOptions' => ['class' => 'col-xs-8'],
                ],
                <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        if ($name == $idProperty) {
                            continue;
                        }
                        echo "            '" . $name . "',\n";
                    }
                } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        if ($idProperty == $column->name) {
                            continue;
                        }
                        $format = $generator->generateColumnFormat($column);
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }
                ?>
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>

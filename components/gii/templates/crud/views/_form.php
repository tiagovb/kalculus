<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$idProperty = $generator->modelClass::primaryKey()[0];
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use kartik\helpers\Html;
use app\helpers\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form ActiveForm */
?>
<div class="row">
    <div class="col-sm-12 col-lg-12">
        <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form box box-primary">
            <div class="box-body">
                    <?= "<?php " ?>$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'formConfig' => ['labelSpan' => 3]]); ?>
                    <?= "                        <p class=\"text-right\">
                            <?= Html::a(Html::icon('menu-left') . ' ' . Yii::t('app', 'Voltar'), ['index'], ['class' => 'btn default']) ?>
                        </p>" ?>

                    <?php foreach ($generator->getColumnNames() as $attribute) {
//                        if ($attribute == $idProperty) {
//                            continue;
//                        }
                        if (in_array($attribute, $safeAttributes)) {
                            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                        }
                    } ?>
                    <?= '<hr>' ?>
                    <?= '<?= $this->render(\'@layouts/_btnFormActions\') ?>' ?>

                    <?= "<?php " ?>ActiveForm::end(); ?>

                </div>
        </div>
    </div>
</div>

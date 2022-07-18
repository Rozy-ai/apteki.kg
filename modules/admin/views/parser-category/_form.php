<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParserCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parser-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'refers_id')->widget(Select2::classname(), ['data' => $category]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

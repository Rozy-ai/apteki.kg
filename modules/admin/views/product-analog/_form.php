<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ProductAnalog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-analog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'analog_id')->widget(Select2::classname(), ['data' => $products]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

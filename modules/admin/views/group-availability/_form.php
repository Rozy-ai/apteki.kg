<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\GroupAvailability */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-availability-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->widget(Select2::classname(), ['data' => $groups]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'url')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

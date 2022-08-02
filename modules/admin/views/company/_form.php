<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'group_id')->widget(Select2::classname(), ['data' => $groups]) ?>

    <?= $form->field($model, 'user_id')->widget(Select2::classname(), ['data' => $users]) ?>

  	<?
  		$img = $model->getImage();
  		if(isset($img)) {
  			echo '<img src="' . $img->getUrl("x50") . '"><br/><br/>';
  		}
  	?>

  	<?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(Yii::$app->params['company_types']) ?>
    <style>
      #map {
          width: 300px;
          height: 300px;
      }
    </style>
    <div class="map_box">
      <p class="header">Кликните по карте, чтобы узнать адрес</p>
      <div id="map"></div>
    </div>

    <?= $form->field($model, 'address')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'lat')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'lon')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'work')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

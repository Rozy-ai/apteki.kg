<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */


$product_id = isset($model->id) ? $model->id : 0;
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hash')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'active')->checkbox() ?>

    <label>Фото</label>
    <?=FileInput::widget([
        'id' => 'image',
        'language' => 'ru',
        'name' => 'image',
        'options' => [
            'multiple' => true,
            'accept' => 'image/*'
        ],
        'pluginEvents' => [
            "filebatchselected" => 'function() { $("#image").fileinput("upload"); }',
            "filesorted" => 'function(event, params) { $.post({url:  "' . Url::to(['/api/images/sorted'])  . '", data: {"product_id": ' .$product_id. ',"hash": "' . $model->hash . '", "newIndex": params.newIndex, "oldIndex": params.oldIndex}}) }'
        ],
        'pluginOptions' => [
            'showCaption' => false,
            'showUpload' => false,
            'showRemove' => false,
            'initialPreview'=> $initialPreview,
            'initialPreviewAsData'=>true,
            'initialPreviewConfig' => $initialPreviewConfig,
            'overwriteInitial'=>false,
            'deleteUrl' => Url::to(['/api/images/delete']),
            'deleteExtraData' => [
                'product_id' => $product_id,
                'hash' => $model->hash,
            ],
            'uploadUrl' => Url::to(['/api/images/upload']),
            'uploadAsync' => true,
            'uploadExtraData' => [
                'product_id' => $product_id,
                'hash' => $model->hash,
            ],
            'allowedFileExtensions' =>  ['jpg', 'png','jpeg'],
            'maxFileCount' => 10,
            'maxFileSize'=>2800,
        ]
    ]);?>
     <br/>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'rating')->textInput() ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), ['data' => $category]) ?>

    <?= $form->field($model, 'producer_id')->widget(Select2::classname(), ['data' => $producer]) ?>

    <?= $form->field($model, 'substance_id')->widget(Select2::classname(), ['data' => $substance]) ?>

    <?= $form->field($model, 'country_id')->widget(Select2::classname(), ['data' => $country]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

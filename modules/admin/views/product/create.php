<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = 'Добавить лекарство';
$this->params['breadcrumbs'][] = ['label' => 'Лекарства', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category,
        'substance' => $substance,
        'country' => $country,
        'producer' => $producer,
        'initialPreview' => $initialPreview,
        'initialPreviewConfig' => $initialPreviewConfig,
    ]) ?>

</div>

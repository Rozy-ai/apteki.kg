<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductAvailability */

$this->title = 'Изменить: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="product-availability-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'companys' => $companys
    ]) ?>

</div>

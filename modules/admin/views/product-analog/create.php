<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProductAnalog */

$this->title = 'Добавить аналог';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-analog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products
    ]) ?>

</div>

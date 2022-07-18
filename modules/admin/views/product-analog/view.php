<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ProductAnalog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-analog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот пункт?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute'=> 'product_id',
                'value' => isset($model->product) ? Html::a($model->product->name, ['product/view', 'id' => $model->product->id]) : null,
                'format' => 'html'
            ],
            [
                'attribute'=> 'analog_id',
                'value' => isset($model->analog) ? Html::a($model->analog->name, ['product/view', 'id' => $model->analog->id]) : null,
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>

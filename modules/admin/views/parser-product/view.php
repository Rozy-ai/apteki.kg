<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ParserProduct */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Parser Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parser-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parser_category_id',
            'type',
            'name',
            'url:url',
            //'status',
        ],
    ]) ?>

</div>

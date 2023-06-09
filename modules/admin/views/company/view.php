<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Аптеки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="company-view">

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

    <?php
  		$images = $model->getImages();
  		$img_html = '';
  		foreach ($images as $image) {
  			 $img_html .= '<img src="' . $image->getUrl("x50") . '"/> ';
  		}
  	?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'Логотип',
                'value' => isset($images) ? $img_html  : "Не указано",
                'format' => 'html',
            ],
            [
                'attribute'=> 'active',
                'value' =>  $model->active ? '<i class="fas fa-check"></i>' : '<i class="fas fa-ban"></i>',
                'format' => 'html'
            ],
            'name',
            [
                'attribute'=> 'group_id',
                'value' => isset($model->group) ? $model->group->name : null,
                'format' => 'html'
            ],
            [
                'attribute' => 'type',
                'value' => Yii::$app->params['company_types'][$model->type],
                'format' => 'html',
            ],
            'address',
            //'lat',
            //'lon',
            'site',
            'contact',
            'work',
        ],
    ]) ?>

</div>

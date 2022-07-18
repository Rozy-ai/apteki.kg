<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="banner-view">

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
      				'attribute' => 'Баннеры',
      				'value' => isset($images) ? $img_html  : "Не указано",
      				'format' => 'html',
      			],
            [
                'attribute'=> 'active',
                'value' =>  $model->active ? '<i class="fas fa-check"></i>' : '<i class="fas fa-ban"></i>',
                'format' => 'html'
            ],
            'url:url',
        ],
    ]) ?>

</div>

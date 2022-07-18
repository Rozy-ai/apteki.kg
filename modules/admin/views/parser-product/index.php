<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParserProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Найденые товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <? foreach ($settings as $setting) : ?>
        <? if($setting->category_status == 0 && $setting->products_status == 0 && $setting->product_status == 0) : ?>
          <?= Html::a('Запустить поиск товаров  ' . Yii::$app->params['parser_types'][$setting->id], ['status', 'id' => $setting->id, "type" => 0], ['class' => 'btn btn-success']) ?>
          <?= Html::a('Запустить добавление товаров ' . Yii::$app->params['parser_types'][$setting->id], ['status', 'id' => $setting->id, "type" => 1], ['class' => 'btn btn-primary']) ?>
          <br/><br/>
        <? endif ?>
      <? endforeach ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => 'app\components\BootstrapLinkPager',
        ],
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            //'parser_category_id',
            [
                'filter' => Yii::$app->params['parser_types'],
                'attribute'=> 'type',
                'content'=>function($data) {
                    return \Yii::$app->params['parser_types'][$data->type];
                }
            ],
            'name',
            //'url:url',
            //'',
            [
                'filter' => Yii::$app->params['parser_product_status'],
                'attribute'=> 'status',
                'content'=>function($data) {
                    return \Yii::$app->params['parser_product_status'][$data->status];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ]
        ]
    ]); ?>


</div>

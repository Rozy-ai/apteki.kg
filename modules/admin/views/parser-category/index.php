<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParserCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Найденные категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
      <? foreach ($settings as $setting) : ?>
        <? if($setting->category_status == 0 && $setting->products_status == 0 && $setting->product_status == 0) : ?>
          <?= Html::a('Запустить поиск категорий ' . Yii::$app->params['parser_types'][$setting->id], ['status', 'id' => $setting->id], ['class' => 'btn btn-success']) ?>
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
            [
                'filter' => Yii::$app->params['parser_types'],
                'attribute'=> 'type',
                'content'=>function($data) {
                    return \Yii::$app->params['parser_types'][$data->type];
                }
            ],
            'name',
            //'refers_id',
            //'parent_id',
            //'url:url',
            //'date',
            [
                'filter' => Yii::$app->params['parser_category_status'],
                'attribute'=> 'status',
                'content'=>function($data) {
                    return \Yii::$app->params['parser_category_status'][$data->status];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'visibleButtons' =>
                [
                    'update' => function ($model) {
                        return $model->url != null;
                    }
                ]
            ]
        ],
    ]); ?>


</div>

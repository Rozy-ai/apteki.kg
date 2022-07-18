<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ParserCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Найденные категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parser-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <? if($model->url != null) : ?>
          <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <? endif ?>
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
                'attribute'=> 'type',
                'value' =>  \Yii::$app->params['parser_types'][$model->type],
                'format' => 'html'
            ],
            'name',
            'url:url',
            'date:datetime',
            [
                'attribute'=> 'refers_id',
                'visible' => $model->url != null,
                'value' =>  isset($model->refers) ? Html::a($model->refers->name, ['category/view', 'id' => $model->refers->id]) : null,
                'format' => 'html'
            ],
            [
                'attribute'=> 'parent_id',
                'visible' => isset($model->parent),
                'value' =>  isset($model->parent) ? Html::a($model->parent->name, ['view', 'id' => $model->parent->id]) : null,
                'format' => 'html'
            ],
        ],
    ]) ?>

    <? if(empty($model->parent)) : ?>
      <br/>
      <h2>Подкатегории</h2>

      <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'pager' => [
              'class' => 'app\components\BootstrapLinkPager',
          ],
          'filterModel' => $searchModel,
          'columns' => [
              //['class' => 'yii\grid\SerialColumn'],

              'id',
              'name',
              //'refers_id',
              //'parent_id',
              //'url:url',
              //'date',
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
    <? endif ?>

</div>

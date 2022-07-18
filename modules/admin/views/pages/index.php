<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            //'meta_description',
            //'meta_keywords',
            //'description',
			[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {url}  {update} {delete} ',
            'buttons' => [
                'url' => function ($url,$model) {
                    return Html::a(
                    '<i class="fas fa-solid fa-globe"></i>',
                    $model->getUrl());
                }
            ],
        ],
        ],
    ]); ?>


</div>

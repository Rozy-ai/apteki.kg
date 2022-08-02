<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="category-view">

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
                'attribute'=> 'active',
                'value' =>  $model->active ? '<i class="fas fa-check"></i>' : '<i class="fas fa-ban"></i>',
                'format' => 'html'
            ],
            'name',
        ],
    ]) ?>

    <? if($model->parent_id == 0) : ?>
        <br/>
        <h2>Подкатегории</h2>

        <p>
            <?= Html::a('Создать подкатегорию', ['create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
                    'attribute'=> 'active',
                    'content'=>function($data) {
                        return $data->active ? '<i class="fas fa-check"></i>' : '<i class="fas fa-ban"></i>';
                    }
                ],
                'name',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <? endif ?>

</div>

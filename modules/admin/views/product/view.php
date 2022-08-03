<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Лекаства', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

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
                'attribute'=> 'active',
                'value' =>  $model->active ? '<i class="fas fa-check"></i>' : '<i class="fas fa-ban"></i>',
                'format' => 'html'
            ],
      			[
      				'attribute' => 'Фото',
      				'value' => isset($images) ? $img_html  : "Не указано",
      				'format' => 'html',
      			],
            'name',
            'price',
            'number',
            'rating',
            [
                'attribute'=> 'category_id',
                'value' => isset($model->category) ? $model->category->name : null,
                'format' => 'html'
            ],
            [
                'attribute'=> 'substance_id',
                'value' => isset($model->substance) ? $model->substance->name : null,
                'format' => 'html'
            ],
            [
                'attribute'=> 'country_id',
                'value' => isset($model->country) ? $model->country->name : null,
                'format' => 'html'
            ],
            [
                'attribute'=> 'producer_id',
                'value' => isset($model->producer) ? $model->producer->name : null,
                'format' => 'html'
            ],
        ],
    ]) ?>

    <br/>
    <h1>Наличие товара по компаниям</h1>
    <p>
        <?= Html::a('Занести наличие', ['product-availability/create', 'product_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProviderAvailability,
        'pager' => [
            'class' => 'app\components\BootstrapLinkPager',
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=> 'company_id',
                'content'=>function($data) {
                    return isset($data->company) ? Html::a($data->company->name, ['company/view', 'id' => $data->company->id]) : null;
                }
            ],
            'price',
            'count',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute(['product-availability/' . $action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <br/>
    <h1>Наличие товара по группам</h1>
    <p>
        <?= Html::a('Занести наличие', ['group-availability/create', 'product_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProviderGroupAvailability,
        'pager' => [
            'class' => 'app\components\BootstrapLinkPager',
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=> 'group_id',
                'content'=>function($data) {
                    return isset($data->group) ? Html::a($data->group->name, ['company-group/view', 'id' => $data->group->id]) : null;
                }
            ],
            'price',
            'count',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute(['group-availability/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <br/>
    <h1>Аналоги</h1>
    <p>
        <?= Html::a('Добавить аналоги', ['product-analog/create', 'product_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProviderAnalog,
        'pager' => [
            'class' => 'app\components\BootstrapLinkPager',
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=> 'analog_id',
                'content'=>function($data) {
                    return isset($data->analog) ? Html::a($data->analog->name, ['product/view', 'id' => $data->analog->id]) : null;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute(["product-analog/" . $action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = 'Создать пункт меню';
$this->params['breadcrumbs'][] = ['label' => Yii::$app->params['menu_types'][$model->type], 'url' => ['index', "type" => $model->type]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupAvailability */

$this->title = 'Изменить: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="group-availability-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'groups' => $groups
    ]) ?>

</div>

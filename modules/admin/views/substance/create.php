<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Substance */

$this->title = 'Добавить вещество';
$this->params['breadcrumbs'][] = ['label' => 'Действующее вещество', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="substance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

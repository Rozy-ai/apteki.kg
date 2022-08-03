<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupAvailability */

$this->title = 'Занести наличие';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-availability-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'groups' => $groups
    ]) ?>

</div>

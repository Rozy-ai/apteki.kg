<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyGroup */

$this->title = 'Добавить группу';
$this->params['breadcrumbs'][] = ['label' => 'Группировка аптек', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

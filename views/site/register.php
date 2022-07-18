<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Авторизация';

?>
<div class="login-form">
    <center>
      <h1>Apteki.kg</h1>
      <p>Регистрация</p>
    </center>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true'placeholder' => $model->getAttributeLabel('name')])->label(false) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')])->label(false) ?>

        <div class="form-group text-center">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn', 'name' => 'login-button']) ?>
            <a href="<?=Url::to(['login']);?>" >Войти <img src="<?=Url::to('../images/icons/arrow_mini_right.svg');?>"></a>
        </div>

    <?php ActiveForm::end(); ?>
</div>

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
      <p>Вход в аккаунт</p>
    </center>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('email')])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>

        <div class="d-flex">
          <?= $form->field($model, 'rememberMe')->checkbox() ?>
          <a href="<?=Url::to(['recover']);?>" >Восстановить аккаунт</a>
        </div>

        <div class="form-group text-center">
            <?= Html::submitButton('Войти', ['class' => 'btn', 'name' => 'login-button']) ?>
            <a href="<?=Url::to(['register']);?>" >Зарегистрироваться <img src="<?=Url::to('../images/icons/arrow_mini_right.svg');?>"></a>
        </div>

    <?php ActiveForm::end(); ?>
</div>

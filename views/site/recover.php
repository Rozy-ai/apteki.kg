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
      <p>Восстановление пароля</p>
    </center>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => $model->getAttributeLabel('email')])->label(false) ?>

        <div class="form-group text-center
        use yii\helpers\Url;">
            <?= Html::submitButton('Продолжить', ['class' => 'btn', 'name' => 'login-button']) ?>
            <a href="<?=Url::to(['login']);?>" >Войти <img src="<?=Url::to('../images/icons/arrow_mini_right.svg');?>"></a>
        </div>

    <?php ActiveForm::end(); ?>
</div>

<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="feedback">
    <br/><br/>
    <div class="row">
      <div class="col-12 col-sm-7">
        <h1>О сервисе</h1>
        <p>«Аптеки в России — www.apteki.su» успешно работает с 2006 года на основе ежедневно обновляемых прайс-листов, предоставляемых аптеками-участниками.<br/>Сервис доступен пользователям в виде сайта и мобильных приложений, позволяя быстро находить лекарственные препараты и другие аптечные товары. </p>
        <p>Apteki.su не аффилирован ни с одним из участников рынка аптечных товаров, что позволяет предоставлять пользователям сервиса актуальную и объективную информацию. Аптеки и аптечные сети, подключенные к сервису, размещают полный перечень имеющихся в наличии товаров. </p>
        <p>Каждая товарная позиция получает отдельную страницу с наименованием, описанием, ценой, информацией о скидках, адресом, схемой проезда, контактами и временем работы аптеки. Подробнее о стоимости и порядке размещения информации смотрите в разделах Прайс-лист и Порядок размещения аптек. Более полно о рекламных возможностях сервиса смотрите в разделе Медиакит. Информацию о функциональных возможностях сервиса смотрите в разделе Презентация.</p>
        <br/><br/>
      </div>
      <div class="col-12 col-sm-5">
        <div class="feedback-block">
          <center>
            <h1>Apteki.kg</h1>
            <p>Добавление аптеки</p>
          </center>

          <?php $form = ActiveForm::begin(); ?>

          <?= $form->field($model, 'mail')->textInput(['placeholder' => $model->getAttributeLabel('mail')])->label(false) ?>

          <?= $form->field($model, 'name')->textInput(['placeholder' => $model->getAttributeLabel('name')])->label(false) ?>

          <?= $form->field($model, 'phone')->textInput(["class" => "phone_mask form-control", 'placeholder' => $model->getAttributeLabel('phone')])->label(false) ?>

          <?= $form->field($model, 'message')->textarea(['rows' => 6, 'placeholder' => $model->getAttributeLabel('message')])->label(false) ?>

          <div class="form-group">
              <?= Html::submitButton('Добавить аптеку', ['class' => 'btn btn-success']) ?>
          </div>

          <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>

    <br/><br/><br/>
</div>


<div class="-form">


</div>

<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Apteka';


$roles = Yii::$app->authManager->getRolesByUser($user->id);
$text = "";
foreach ($roles as $role) {
    $text .= $role->description . " ";
}

?>

<div class="profile">
    <div class="profile-user">
      <div class="profile-logo"></div>
      <div class="profile-info">
        <h4><?=$user->name?></h4>
        <p><?=$text?></h4>
      </div>
      <div class="profile-button">
        <a href="<?=Url::to(["site/logout"])?>"><img src="<?=Url::to(["/images/icons/login.svg"])?>"/></a>
      </div>
    </div>

    <br/>
    <form id="search-form-availability" method="get" action="<?=Url::to(['index']);?>">
      <div style="margin:0px;" class="block-search">
          <input class="form-search" type="text" name="q" placeholder="Поиск лекарств" value="<?=$q?>" aria-label="Поиск лекарств">
          <button type="submit" form="search-form-availability" class="btn">Найти</button>
      </div>
    </form>
    <br/>

    <div class="row product-availability">
      <div class="col-2 col-sm-2 m-none">
      </div>
      <div class="col-6 col-sm-4">
      </div>
      <div class="col-3 col-sm-3">
        <h4>Цена</h4>
      </div>
      <div class="col-3 col-sm-3">
        <h4>В наличии</h4>
      </div>
  </div>
		<? $form = ActiveForm::begin(); ?>
      <? foreach ($products as $product)  : ?>
        <div class="row product-availability">
          <div class="col-2 col-sm-2 m-none">
            <? if($product->getImage() != null) : ?>
              <img src="<?=$product->getImage()->getUrl("75x75")?>">
            <? endif ?>
          </div>
          <div class="col-6 col-sm-4">
            <h4><?=$product->name?></h4>
          </div>
          <div class="col-3 col-sm-3">
            <?=$form->field($availabilityForm, 'price[' . $product->id . ']', ['inputOptions' =>  ['value' => isset($product->availabilityOne) ? $product->availabilityOne->price : 0]])->label(false)?>
          </div>
          <div class="col-3 col-sm-3">
            <?=$form->field($availabilityForm, 'count[' . $product->id . ']', ['inputOptions' =>  ['value' => isset($product->availabilityOne) ? $product->availabilityOne->count : 0]])->label(false)?>
          </div>
      </div>
      <? endforeach ?>
  		<? if(count($products) != 0) : ?>
          <center><br/>
      			<?=Html::submitButton('Сохранить', ['class' => 'btn']); ?>
          </center>
    		<? endif ?>
  	<? ActiveForm::end(); ?>

    <br/>
    <?= app\components\BootstrapLinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>

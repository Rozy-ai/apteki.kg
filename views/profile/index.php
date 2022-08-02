<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Apteka';


$roles = Yii::$app->authManager->getRolesByUser($user->id);
$text = "";
foreach ($roles as $role) {
    $text .= $role->description . " ";
}

?>

<div class="profile row">
  <div class="col-12 col-sm-6">
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
    <br/>
    <h2><img src="../images/icons/profile_favorite.svg"/> Избранное</h2>
    <? foreach ($products as $product)  : ?>
      <div class="product-favorite">
        <div class="d-flex">
          <? if($product->getImage() != null) : ?>
            <img src="<?=$product->getImage()->getUrl("75x75")?>">
          <? endif ?>
          <h4><?=$product->name?></h4>
        </div>
        <div class="text-right">
          <a href="<?=Url::to(['product/index', 'id' => $product->id]);?>" class="btn">Проверить наличие</a>
        </div>
      </div>
    <? endforeach ?>

    <br/>
    <br/>
    <br/>
  </div>
  <div class="col-12 col-sm-6">
    <h2><img src="../images/icons/profile_history.svg"/> История</h2>

    <br/>
    <br/>
    <br/>
  </div>
</div>

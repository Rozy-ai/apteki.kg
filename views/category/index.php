<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Apteki.kg - легкий поиск лекарств в твоем городе';
?>
<div class="site-index">
  <br/><br/>
  <h2>Каталог</h2>
  <div class="category-block row">
    <? foreach ($products as $product)  : ?>
      <div class="col-6 col-sm-3">
        <div class="product">
          <div class="d-flex">
            <div class="star"><?=$product->rating?> <i class="fas fa-solid fa-star"></i></div>
            <? if(!Yii::$app->user->isGuest) : ?>
              <button id="favorite" data-article="<?=$product->id?>"><i class="<?=$product->favorite ? "fas fa-heart" : "far fa-heart" ?>"></i></button>
            <? endif ?>
          </div>
          <a href="<?=Url::to(['product/index', 'id' => $product->id]);?>">
            <? if($product->getImage() != null) : ?>
              <img src="<?=$product->getImage()->getUrl("200x200")?>">
            <? endif ?>
            <h4><?=$product->name?></h4>
            <span class="number">Артикул: <?=$product->number?></span>
            <div class="d-flex">
              <div class="price">От <?=$product->price?> c.</div>
              <div class="count"><?=$product->availability_count?> пред.</div>
            </div>
          </a>
          <a href="<?=Url::to(['product/index', 'id' => $product->id]);?>" class="btn">Цена на карте</a>
        </div>
      </div>
    <? endforeach ?>
  </div>

  <br/>
  <?= app\components\BootstrapLinkPager::widget([
      'pagination' => $pages,
  ]); ?>
</div>

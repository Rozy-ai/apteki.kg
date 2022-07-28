<?php

use yii\helpers\Url;
use yii\bootstrap4\Carousel;

/** @var yii\web\View $this */

$this->title = 'Apteka';

$carousel = [];

foreach ($banners as $banner) {
    $image = $banner->getImage();
    if($image) {
      array_push($carousel, [
          'content' => '<div class="banner"><a href="' . $banner->url . '"><img src="' . $image->getUrl() . '"/></a></div>',
          'caption' => '',
          'options' => []
      ]);
    }
}

?>
<div class="site-index">

      <? if(count($carousel) != 0) : ?>
        <?=Carousel::widget([
            'items' => $carousel,
            'options' => ['class' => 'carousel slide', 'data-interval' => 5000],
        ]);?>
      <? endif ?>

      <br/><br/>
      <h2>Популярное</h2>
      <div class="category-block row">
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/category/1.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/category/2.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/category/3.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/category/4.png');?>">
        </div>
      </div>

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
                  <div class="count"><?=count($product->availability)?> пред.</div>
                </div>
              </a>
              <a href="<?=Url::to(['product/index', 'id' => $product->id]);?>" class="btn">Цена на карте</a>
            </div>
          </div>
        <? endforeach ?>
      </div>
      <div class="catalog-button">
        <a href="<?=Url::to(['category/index']);?>" >Весь каталог <img src="<?=Url::to('../images/icons/arrow_right.svg');?>"></a>
      </div>

      <div class="company-block row">
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/1.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/2.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/3.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/4.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/5.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/6.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/7.png');?>">
        </div>
        <div class="col-6 col-sm-3">
          <img src="<?=Url::to('../images/company/8.png');?>">
        </div>
      </div>
</div>

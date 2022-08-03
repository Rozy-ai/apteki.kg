<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$images = $product->getImages();
$image = array_shift($images);

$this->title = 'Apteka';
?>
<div class="site-search">
    <h1 id="main"><?=$product->name?></h1>
    <ul id="product-menu" class="top-menu">
      <li><a class="active" href="#main">Основное</a></li>
      <? if($product->description) : ?>
        <li><a href="#description">Описание</a></li>
      <? endif ?>
      <? if(count($products) != 0) : ?>
        <li><a href="#analog">Аналоги</a></li>
      <? endif ?>
    </ul>


    <div class="product-block row">
      <div class="col-6 col-sm-4 order-1 order-sm-1">
        <? if(isset($image)) : ?>
          <a class='main-image' data-fancybox="gallery" href="<?=$image->getUrl()?>" data-caption="Caption #1"><img  src="<?=$image->getUrl("500x500")?>" alt=""></a>
        <? endif ?>
        <? if(isset($images)) : ?>
          <div class="block-images">
              <? foreach ($images as $image) : ?>
                  <a class='image_slide'data-fancybox="gallery" href="<?=$image->getUrl()?>" data-caption="Caption #2"><img class='image_slide' src="<?=$image->getUrl("500x500")?>" alt=""></a>
              <? endforeach ?>
          </div>
        <? endif ?>
      </div>
      <div class="col-12 col-sm-4 order-3 order-sm-2">
        <ul class="params">
            <? if(isset($product->substance)) : ?>
              <li>Действующее вещество: <span><?=$product->substance->name?></span></li>
            <? endif ?>
            <? if(isset($product->producer)) : ?>
              <li>Производитель: <span><?=$product->producer->name?></span></li>
            <? endif ?>
            <? if(isset($product->country)) : ?>
              <li>Страна: <span><?=$product->country->name?></span></li>
            <? endif ?>
        </ul>
      </div>
      <div class="col-6 col-sm-4 order-2 order-sm-3">
        <div class="price">От <span><?=$product->price?> c.</span></div>
        <div class="description">Есть в наличии</div>
        <br/>
        <a href="#availability" class="btn-select">Выбрать</a>
      </div>
    </div>


    <br/><br/>
    <h2 id="availability">Торговые предложения</h2>
    <div class="buttons-availability d-flex">
      <button id="button-list" class="btn active">Список</button>
      <button id="button-map" class="btn">На карте</button>
    </div>


      <script>
          ymaps.ready(init);

          function init() {
              window.myMap = new ymaps.Map("availability-map", {
                  center: [42.876366, 74.603710],
                  zoom: 11
              }, {
                  searchControlProvider: 'yandex#search'
              });

              <? foreach ($product->groupAvailability as $groupAvailability) : ?>
                <? if($groupAvailability->group) : ?>
                    <? foreach ($groupAvailability->group->company as $item) : ?>
                        <? if($item->type != 2) : ?>
                          myMap.geoObjects.add(new ymaps.Placemark([<?=$item->lat?>, <?=$item->lon?>], {
                              iconCaption: '<?=$groupAvailability->price?> c.',
                              balloonContentHeader: '<?=$item->name?>',
                              balloonContentBody: '<?=$groupAvailability->price?> c.<br/><?=$item->address?>',
                          }, {
                              preset: 'islands#darkGreenIcon'
                          }));
                        <? endif ?>
                    <? endforeach ?>
                <? endif ?>
              <? endforeach ?>
              <? foreach ($product->availability as $item) : ?>
                <? if($item->company->type != 2) : ?>
                  myMap.geoObjects.add(new ymaps.Placemark([<?=$item->company->lat?>, <?=$item->company->lon?>], {
                      iconCaption: '<?=$item->price?> c.',
                      balloonContentHeader: '<?=$item->company->name?>',
                      balloonContentBody: '<?=$item->price?> c.<br/><?=$item->company->address?>',
                  }, {
                      preset: 'islands#darkGreenIcon'
                  }));
                <? endif ?>
              <? endforeach ?>
          }
        function viewMap(lat, lon) {
          $("#button-map").click();
          window.myMap.setCenter([lat, lon], 15, {
              checkZoomRange: true
          });
        }
      </script>
      <style>
        #availability-map {
          margin-top: 20px;
          width: 100%;
          height: 70vh;
          display: none;
        }
      </style>
      <div id="availability-map"></div>

    <div class="availability-list">
        <? foreach ($product->groupAvailability as $groupAvailability) : ?>
            <? if($groupAvailability->group) : ?>
                <? foreach ($groupAvailability->group->company as $item) : ?>
                    <div class="availability-item row">
                        <div class="col-6 col-sm-6">
                            <h4><?=$item->name?> <span><?=$item->rating?></span></h4>
                            <div class="work"><?=$item->work?></div>
                        </div>
                        <div class="col-6 col-sm-4">
                            <div class="price">От <span><?=$groupAvailability->price?> c.</span></div>
                            <div class="description">Есть в наличии</div>
                        </div>
                        <div class="col-6 col-sm-2">
                            <? if($item->type == 2) : ?>
                                <a href="<?=$groupAvailability->url?>" class="btn">Купить</a>
                            <? else : ?>
                                <button onClick="viewMap(<?=$item->lat?>, <?=$item->lon?>)" class="btn">Показать на карте</button>
                            <? endif ?>
                        </div>
                    </div>
                <? endforeach ?>
            <? endif ?>
        <? endforeach ?>
        <? foreach ($product->availability as $item) : ?>
            <div class="availability-item row">
              <div class="col-6 col-sm-6">
                <h4><?=$item->company->name?> <span><?=$item->company->rating?></span></h4>
                <div class="work"><?=$item->company->work?></div>
              </div>
              <div class="col-6 col-sm-4">
                  <div class="price">От <span><?=$item->price?> c.</span></div>
                  <div class="description">Есть в наличии</div>
              </div>
              <div class="col-6 col-sm-2">
                <? if($item->company->type == 2) : ?>
                 <a href="<?=$item->url?>" class="btn">Купить</a>
               <? else : ?>
                <button onClick="viewMap(<?=$item->company->lat?>, <?=$item->company->lon?>)" class="btn">Показать на карте</button>
              <? endif ?>
              </div>
            </div>
        <? endforeach ?>
    </div>

    <? if($product->description) : ?>
      <br/><br/>
      <h2 id="description">Описание</h2>
      <?=$product->description ?>
    <? endif ?>


    <? if(count($products) != 0) : ?>
      <br/><br/>
      <h2 id="analog">Похожие товары</h2>
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
    <? endif ?>


    <br/><br/><br/>
</div>

<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Apteka';
?>
<div class="search-index">

  <ul class="top-menu">
      <li class="active"><a href="<?=Url::to(['index']);?>">По алфавиту</a></li>
  </ul>

  <form id="search-form-page" method="get" action="<?=Url::to(['search/index']);?>">
    <div style="margin:0px;" class="block-search">
        <input class="form-search" type="text" name="q" placeholder="Поиск лекарств" aria-label="Поиск лекарств">
        <button type="submit" form="search-form-page" class="btn">Найти</button>
    </div>
  </form>

  <ul class="search-bar">
      <li><a href="<?=Url::to(['index', 'type' => 1]);?>:">А-Я</a></li>
      <li><a href="<?=Url::to(['index', 'type' => 2]);?>">A-Z</a></li>
      <li><a href="<?=Url::to(['index', 'type' => 3]);?>">0-9</a></li>
  </ul>

      <script>
          ymaps.ready(init);

          function init() {
              window.myMap = new ymaps.Map("availability-map", {
                  center: [42.876366, 74.603710],
                  zoom: 11
              }, {
                  searchControlProvider: 'yandex#search'
              });

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
        }
      </style>


        <br/>
              <br/>
      <h2><?=$product->name?></h2>
      <br/>

      <div class="row">
        <div class="col-12 col-sm-3  order-2 order-sm-1" style="height: 70vh;overflow: auto;">
          <? foreach ($product->availability as $item) : ?>
            <? if($item->company->type != 2) : ?>
              <div onClick="viewMap(<?=$item->company->lat?>, <?=$item->company->lon?>)" class="product-company-item">
                <? if($item->company->getImage() != null) : ?>
                  <img class="company-logo" src="<?=$item->company->getImage()->getUrl("75x75")?>">
                <? endif ?>
                <h2><?=$item->company->name?></h2>
                <p><img src="../images/icons/phone.svg"/> <?=$item->company->contact?></p>
                <p><img src="../images/icons/map.svg"/> <?=$item->company->address?></p>
                <p><img src="../images/icons/time.svg"/> <?=$item->company->work?></p>
              </div>
            <? endif ?>
          <? endforeach ?>
        </div>
        <div class="col-12 col-sm-9  order-1 order-sm-2">
          <div id="availability-map"></div>
        </div>
      </div>
      <br/><br/>

      <div class="availability-list">
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

  <br/>
  <br/>
</div>

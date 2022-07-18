<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Apteka';

$image = $company->getImage();
?>


<script>
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("company-map", {
            center: [<?=$company->lat?>, <?=$company->lon?>],
            zoom: 12
        }, {
            searchControlProvider: 'yandex#search'
        });

        myMap.geoObjects.add(new ymaps.Placemark([<?=$company->lat?>, <?=$company->lon?>], {
            iconCaption: '<?=$company->name?>',
            balloonContentHeader: '<?=$company->name?>',
            balloonContentBody: '<?=$company->address?>',
        }, {
            preset: 'islands#<?=$company->type == 0 ? "nightCircleDotIcon" : "brownCircleDotIcon"?>'
        }));
    }
</script>
<style>
  #company-map {
    width: 100%;
    height: 70vh;
  }
</style>

<br/><br/>
<div class="company-index">
    <div class="row">
      <div class="col-12 col-sm-5">
        <h1><img src="<?=$image->getUrl("x50")?>"/> <?=$company->name?></h1>
        <p class="description"><?=$company->description?></p>
        <div class="row">
          <div class="col-6 col-sm-6">
            <h4><?=$company->address?><h4>
            <span>Адрес аптеки</span>
          </div>
          <div class="col-6 col-sm-6">
            <h4><?=$company->rating?><h4>
            <span>Рейтинг</span>
          </div>
          <div class="col-6 col-sm-6">
            <h4><?=$company->work?><h4>
            <span>Режим работы</span>
          </div>
          <div class="col-6 col-sm-6">
            <h4><?=$company->contact?><h4>
            <span>Контакты</span>
          </div>
        </div>
        <br/>
        <br/>
      </div>
      <div class="col-12 col-sm-7">
        <div id="company-map"></div>
      </div>
    </div>

    <br/><br/><br/>
</div>


<?php

use kv4nt\owlcarousel\OwlCarouselWidget;
use yii\helpers\Url;

$this->title = 'Apteka';
?>

<script>
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("main-map", {
            center: [42.876366, 74.603710],
            zoom: 11
        }, {
            searchControlProvider: 'yandex#search'
        });

        <? foreach ($companys as $company) : ?>
        myMap.geoObjects.add(new ymaps.Placemark([<?=$company->lat?>, <?=$company->lon?>], {
            iconCaption: '<?=$company->name?>',
            balloonContentHeader: '<?=$company->name?>',
            balloonContentBody: '<?=$company->address?>',
            balloonContentFooter: '<a class="btn btn-sm" href="<?=Url::to(['company/index', 'id' =>  $company->id]);?>" >Подробнее</a>'
        }, {
            preset: 'islands#darkGreenIcon'
        }));
        <? endforeach ?>
    }
</script>
<style>
  #main-map {
    width: 100%;
    height: 70vh;
  }
</style>
<div id="main-map"></div>

<br/>
<h1>Аптеки</h1>

<? OwlCarouselWidget::begin([
    'container' => 'div',
    'assetType' => OwlCarouselWidget::ASSET_TYPE_CDN,
    'jqueryFunction' => 'jQuery',// or $
    'containerOptions' => [
        'id' => 'company-container',
        'class' => 'container-class owl-theme'
    ],
    'pluginOptions'    => [
        'dots' => false,
        'nav' => true,
        'navText' => ["<img src='../images/icons/owl_left_arrow.svg' />", "<img src='../images/icons/owl_right_arrow.svg' />"],
        'margin' => 10,
        'smartSpeed' => 1000,
        'responsive' => [
    			0 => [
    				'items' => 1
    			],
    			600 => [
    				'items' => 1
    			],
    			1000 => [
    				'items' => 3
    			]
    		],
    ]
]);
?>


<? foreach ($companys as $company) : ?>
  <div class="company-item">
    <h2><?=$company->name?></h2>
    <p class="address"><?=$company->address?></p>
    <p class="contact">Контактные данные: <span><?=$company->contact?></span></p>
    <div class="row">
      <div class="col-6 col-sm-6">
        <a href="<?=Url::to(['company/index', 'id' => $company->id]);?>" class="btn">Подробнее</a>
      </div>
      <div class="col-6 col-sm-6">
        <p class="work"><?=$company->work?></p>
      </div>
    </div>
  </div>
<? endforeach ?>


<?php OwlCarouselWidget::end(); ?>

<br/>
<br/>

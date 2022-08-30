<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Apteki.kg - легкий поиск лекарств в твоем городе';
?>
<div class="search-index">

  <ul class="top-menu">
      <li class="active"><a href="<?=Url::to(['index']);?>">По алфавиту</a></li>
  </ul>

  <form id="search-form-page" method="get" action="<?=Url::to(['search/index']);?>">
    <div style="margin:0px;" class="block-search type-search-default">
        <input class="form-search" type="text" name="q" placeholder="Поиск лекарств" value='<?=$q?>' aria-label="Поиск лекарств">
        <button type="submit" form="search-form-page" class="btn">Найти</button>
    </div>
  </form>

  <ul class="search-bar">
      <li <?=$type == 1 ? 'class="active"' : ''?> ><a href="<?=Url::to(['index', 'type' => 1]);?>:">А-Я</a></li>
      <li <?=$type == 2 ? 'class="active"' : ''?>><a href="<?=Url::to(['index', 'type' => 2]);?>">A-Z</a></li>
      <li <?=$type == 3 ? 'class="active"' : ''?>><a href="<?=Url::to(['index', 'type' => 3]);?>">0-9</a></li>
  </ul>


  <div class="search-products">
    <div class="row">
      <? foreach ($products as $product)  : ?>
        <div class="col-6 col-sm-3">
          <a href="<?=Url::to(['search/product', 'id' => $product->id]);?>"><?=$product->name?></a>
        </div>
      <? endforeach ?>
    </div>
  </div>

  <br/>
  <?= app\components\BootstrapLinkPager::widget([
      'pagination' => $pages,
  ]); ?>
</div>

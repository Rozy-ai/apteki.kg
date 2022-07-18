<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Apteka';
?>
<div class="search-index">

  <ul class="top-menu">
      <li class="active"><a href="<?=Url::to(['index']);?>">По алфавиту</a></li>
  </ul>

  <form id="search-form" method="get" action="<?=Url::to(['search/index']);?>">
    <div style="margin:0px;" class="block-search">
        <input class="form-search" type="text" name="q" placeholder="Поиск лекарств" value="<?=$q?>" aria-label="Поиск лекарств">
        <button type="submit" form="search-form" class="btn">Найти</button>
    </div>
  </form>

  <ul class="search-bar">
      <li <?=$type == 1 ? 'class="active"' : ''?> ><a href="<?=Url::to(['index', 'type' => 1]);?>:">А-Я</a></li>
      <li <?=$type == 2 ? 'class="active"' : ''?>><a href="<?=Url::to(['index', 'type' => 2]);?>">A-Z</a></li>
      <li <?=$type == 3 ? 'class="active"' : ''?>><a href="<?=Url::to(['index', 'type' => 3]);?>">0-9</a></li>
  </ul>


  <div class="search-products">
    <ul>
      <? foreach ($products as $product)  : ?>
        <li><a href="<?=Url::to(['search/product', 'id' => $product->id]);?>"><?=$product->name?></a></li>
      <? endforeach ?>
    </ul>
  </div>

  <br/>
  <br/>
</div>

<?php

/** @var yii\web\View $this */
/** @var string $content */

use Yii;
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
  	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<?=Yii::$app->params['ymap_api_key']?>" type="text/javascript"></script>
    <?php $this->head() ?>
    <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   var z = null;m[i].l=1*new Date();
   for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
   k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(90014332, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/90014332" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
  <nav class="navbar">
    <div class="navbar-mobile f-none">
        <a href="<?=Url::home()?>">
            <img src="<?=Url::to(['../images/logo-mini.png']);?>">
        </a>
        <a class="logout" href="<?=Yii::$app->user->isGuest ? Url::to(['site/login']) : Url::to(['profile/index']) ?>">
            <img src="<?=Url::to(['../images/icons/profile.svg']);?>">
        </a>
    </div>
    <div class="navbar-mini m-none">
        <ul>
            <?=app\components\menuWidget::widget(["type" => 0])?>
      </ul>
    </div>
    <div class="container">
      <div class="navbar-header d-flex">
        <a class="logo m-none" href="<?=Url::home()?>">
          <img src="<?=Url::to(['../images/logo.png']);?>">
        </a>
        <button class="navbar-toggler f-none" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <img src="<?=Url::to(['../images/icons/menu.svg']);?>">
        </button>
        <form id="search-form" method="get" action="<?=Url::to(['search/index']);?>">
          <div class="block-search type-search-default">
              <input class="form-search" type="text" name="q" placeholder="Поиск лекарств" aria-label="Поиск лекарств">
              <button type="submit" form="search-form" class="btn">Найти</button>
          </div>
            <div class="search-suggest">123<br/>456</div>
        </form>
        <? if(Yii::$app->user->isGuest) : ?>
          <a href="<?=Url::to(['site/login']);?>" class="btn btn-login m-none">Войти</a>
        <? else : ?>
          <a href="<?=Url::to(['profile/index']);?>" class="btn btn-login m-none"><i class="far fa-solid fa-user"></i></a>
        <? endif?>
        <a href="mailto:<?=Yii::$app->params['supportEmail']?>" class="btn btn-mail m-none">Напишите нам</a>
      </div>
    </div>
  </nav>
  <div class="navbar-main">
      <div class="container">
        <ul>
          <?=app\components\categoryWidget::widget()?>
        </ul>
      </div>
  </div>

    <div class="container">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <div class="navbar-menu row">
              <?=app\components\menuWidget::widget(["type" => 0, "style" => 1])?>
          </div>
        </div>
    </div>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto text-white">
    <div class="container">
      <div class="row">
        <div class="col-6 order-6  order-sm-1 col-sm-4">
            <h4>Наши приложения</h4>
              <div class="mobile-app row">
                <div class="col-12 col-sm-6">
                  <img src="<?=Url::to(['../images/apple.png']);?>">
                </div>
                <div class="col-12 col-sm-6">
                  <img src="<?=Url::to(['../images/google.png']);?>">
                </div>
              </div>

            <p>Установите удобные приложения для поиска лекарств в Apple App Store и Google Play.</p>
            <p class="m-none">© 2020 Единая справочная Аптек в Киргизии.<br/>Все права защищены.</p>
        </div>
        <div class="col-6 order-4 order-sm-2 col-sm-4">
            <h4 class="m-none">О сервисе</h4>
            <ul class="two m-none">
              <?=app\components\menuWidget::widget(["type" => 1])?>
          </ul>
          <h4>Пользователям</h4>
          <ul class="two">
            <?=app\components\menuWidget::widget(["type" => 3])?>
        </ul>
        </div>
        <div class="col-6 order-3 order-sm-3 col-sm-2">
            <h4>О сервисе</h4>
            <ul>
              <?=app\components\menuWidget::widget(["type" => 2])?>
          </ul>
        </div>
        <div class="col-6 order-5 order-sm-4 col-sm-2">
            <h4>Профессионалам</h4>
            <ul>
              <?=app\components\menuWidget::widget(["type" => 4])?>
          </ul>
        </div>
      </div>
    </div>
</footer>


<? Modal::begin([
    'id' => 'sub-menu',
    'closeButton' => false,
]); ?>
<button type="button" id="close-button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
<?=app\components\subcategoryWidget::widget()?>


<? Modal::end(); ?>

<?php $this->endBody() ?>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>

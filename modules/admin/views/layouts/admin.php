<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AdminAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<?=\Yii::$app->params['ymap_api_key']?>" type="text/javascript"></script>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?
      $menu_array = [];
      foreach (Yii::$app->params['menu_types'] as $id => $name) {
        array_push($menu_array, ['visible' => Yii::$app->user->can('adminPermission'), 'label' => $name, 'url' => ['/admin/menu/index', "type" => $id]]);
      }
    ?>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => [
            [
                'visible' => Yii::$app->user->can('adminPermission'),
                'label' => 'Сайт',
                'items' => [
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Страницы', 'url' => ['/admin/pages/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Баннеры', 'url' => ['/admin/banner/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Обращения', 'url' => ['/admin/feedback/index']],
               ],
            ],
            [
                'visible' => Yii::$app->user->can('adminPermission'),
                'label' => 'Каталог',
                'items' => [
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Категории', 'url' => ['/admin/category/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Товары', 'url' => ['/admin/product/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Группировка аптек', 'url' => ['/admin/company-group/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Аптеки', 'url' => ['/admin/company/index']],
               ],
            ],
            [
                'visible' => Yii::$app->user->can('adminPermission'),
                'label' => 'Парсер',
                'items' => [
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Категории', 'url' => ['/admin/parser-category/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Товары', 'url' => ['/admin/parser-product/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Логи', 'url' => ['/admin/logs/index']],
               ],
            ],
            [
                'visible' => Yii::$app->user->can('adminPermission'),
                'label' => 'Справочники',
                'items' => [
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Действующее вещество', 'url' => ['/admin/substance/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Производитель', 'url' => ['/admin/producer/index']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => 'Страна', 'url' => ['/admin/country/index']],
               ],
            ],
            [
                'visible' => Yii::$app->user->can('adminPermission'),
                'label' => 'Пользователи',
                'items' => [
                    '<div  class="dropdown-header">Пользователи</div >',
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => '<span class="glyphicon glyphicon-user"></span> Клиенты', 'url' => ['/admin/users/index']],
                    '<div  class="dropdown-header">Управление доступом</div >',
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => '<span class="glyphicon glyphicon-lock"></span> Маршруты', 'url' => ['/rbac/route']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => '<span class="glyphicon glyphicon-lock"></span> Доступы', 'url' => ['/rbac/permission']],
                    ['visible' => Yii::$app->user->can('adminPermission'), 'label' => '<span class="glyphicon glyphicon-lock"></span> Роли', 'url' => ['/rbac/role']],
                ],
            ],
            [
                'visible' => Yii::$app->user->can('adminPermission'),
                'label' => 'Меню',
                'items' => $menu_array,
            ]
        ],
    ]);
    ?>
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

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; Apteka.kg <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

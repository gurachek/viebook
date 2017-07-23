<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- <link rel="apple-touch-icon" sizes="57x57" href="/images/apple-icon-57x57.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="60x60" href="/images/apple-icon-60x60.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="72x72" href="/images/apple-icon-72x72.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="76x76" href="/images/apple-icon-76x76.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="114x114" href="/images/apple-icon-114x114.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="120x120" href="/images/apple-icon-120x120.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="144x144" href="/images/apple-icon-144x144.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="152x152" href="/images/apple-icon-152x152.png"> -->
    <!-- <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-icon-180x180.png"> -->
    <!-- <link rel="icon" type="image/png" sizes="192x192"  href="/images/android-icon-192x192.png"> -->
    <!-- <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png"> -->
    <!-- <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon-96x96.png"> -->
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png"> -->
    <!-- <link rel="manifest" href="/images/manifest.json"> -->
    <!-- <meta name="msapplication-TileColor" content="#ffffff"> -->
    <!-- <meta name="msapplication-TileImage" content="/images/ms-icon-144x144.png"> -->
    <!-- <meta name="theme-color" content="#ffffff"> -->
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" style="margin-top: 5px;">
    <?php
    // <h3 style="margin: 0; margin-top: -1.3px; float: left; margin-left: 10px;">Вайбук</h3>
    NavBar::begin([
        'brandLabel' => '<img src="/images/logo.png" width="40" height="40" style="margin-top: -9px; float: left">
            <img src="/images/logo_text.svg" width="130" height="30" style="margin-top: -3px;">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $leftMenu = [
        ['label' => 'Книги', 'url' => ['/book/list']],
    ];

    $leftMenu[] = ['label' => 'Авторы', 'url' => ['/author/list']];
    $leftMenu[] = ['label' => 'Пользователи', 'url' => ['/user/list']];

     echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenu,
    ]);

    $menuItems = [
        ['label' => 'Главная', 'url' => ['/app/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Фид-лента', 'url' => ['feed/index']] ;
        $menuItems[] = '<li>'
        .'<a href="'. Yii::$app->getUrlManager()->createAbsoluteUrl(['user/index']) .'" style="width: 30px; height: 30px;">'
        .'<div style="background: url(/images/users/'. Yii::$app->user->identity->image .')' 
        .'no-repeat center; background-size: cover; width: 30px; height: 30px;'
        .'border-radius: 100px; margin-top: -5px;"></div></li>'
        .'</a>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end(); 
    ?>
    <br>
    <br>
    <br>
    <div class="container" style="background: #FFFFFF; border: 1px solid #FFFFF7;">
        <?php Alert::widget() ?>

        <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Viebook <?= date('Y') ?></p>
        <p class="pull-right">Gurachek</p>
        <p class="text-center">
            <a href="https://vk.com/viebook" target="_blank">
                <img src="/images/vk.png" width="30" height="30">
            </a>
        </p>
    </div>
</footer>

<footer class="mobile-footer">
    <p class="text-center">Здесь был футер.</p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

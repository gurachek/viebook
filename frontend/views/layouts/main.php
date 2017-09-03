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
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" />
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap" style="margin-top: 5px;">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/images/logo.png" width="40" height="40" style="margin-top: -9px; float: left">
            <img src="/images/logo_text.svg" width="130" height="30" style="margin-top: -7px;">',
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

    // if (Yii::$app->user->can('godmode'))
        // $leftMenu[] = ['label' => 'Рецензии', 'url' => ['/god/reviews']];

     echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenu,
    ]);

    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
    } else {
    
        $menuItems[] = '<li>'
        .'<a href="'. Yii::$app->getUrlManager()->createAbsoluteUrl(['/review/write']) .'" class="btn btn-default" style="padding: 5px; margin-top: 10px;">'
        .'&nbsp;'
        .'<span class="glyphicon glyphicon-pencil"></span> '
        .'Написать'
        .'&nbsp;'
        .'</a>'
        .'</li>';

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
    <div class="container main-block" style="">
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

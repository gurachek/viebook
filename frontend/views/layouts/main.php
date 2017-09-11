<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$emailSend = Yii::$app->getUrlManager()->createAbsoluteUrl(['site/email']);

$customJs = <<<JS

jQuery(document).ready(function () {

    if (!$.session.get('promo_closed')) {
        jQuery('.promo').css('display', 'block');
    }    
    
    jQuery('.close-promo .sure').click(function () {
        jQuery('.promo').css('display', 'none');
        $.session.set('promo_closed', true);
    });
    
    jQuery('.submit').click(function () {
        var email = jQuery('.email').val();
        jQuery.ajax({
            url: '$emailSend',
            method: 'POST',
            data: {
                email: email,
            },
            success: function (data) {
                var info = JSON.parse(data);
                if (info.status) {
                    jQuery('.let_email').css('display', 'none');
                    jQuery('.ty_for_email').css('display', 'block');
                    $.session.set('promo_closed', true);
                }
            },
        });
    });

});

JS;

$this->registerJs($customJs);

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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-106045460-1', 'auto');
  ga('send', 'pageview');

</script>

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
    <div class="container promo" style="background: rgba(123, 164, 210, 0.1); color: #444; border: 1px solid #7BA4D2;">
        <h3 class="text-center" style="margin: 0">Минутку внимания!</h3>
        <div style="color: #444; padding-top: 5px; width: 80%; margin: 0 auto; font-size: 16px; line-height: 1.6em;">
            Сейчас на главной странице вы видите тестовые рецензии, которые добавлены, чтобы показать как это вообще работает. Со временем сайт будет наполняться реальными рецензиями от профессионалов своей сферы.<br>
            Суть проекта - предоставить вам обзоры книг, чтобы вы могли выбрать только те книги, которые реально будут полезны для развития в выбранной сфере.
            Для тех, кто не знает с чего начать и как развиваться, мы готовим к запуску функционал, который поможет четко выстроить путь развития и будем курировать вас в процессе обучения. Вы самостоятельно изучаете то, что вам интересно. А мы лишь даем инструмент, который поможет сэкономить ваше время.
            <br>
            <br>
            <p class="text-center">Хотите получать еженедельную рассылку с подборкой рецензий?</p>
            <div class="let_email">
                <div class="form-inline" id="sendEmail">
                <div class="form-group">
                    <input type="email" class="form-control email" placeholder="love@viebook.ru">
                    <button class="btn btn-success submit">
                        <span class="glyphicon glyphicon-send"></span>
                        &nbsp;Отправить
                    </button>
                </div>
                </div>
                <small style="font-size: 12px; line-height: 0.5em;">* Мы не будем надоедать спамом. Только полезная для Вас информация.</small>
            </div>  
            <div class="ty_for_email">
                <span class="glyphicon glyphicon-ok"></span>
                 Спасибо за доверие, ожидайте рассылку
            </div>   
        </div>
        <div class="close-promo">
            <a class="sure">Закрыть</a>
        </div>
    </div>
    <br>
    <div class="container main-block">
        <?php Alert::widget() ?>

        <?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Viebook <?= date('Y') ?></p>
        <p class="pull-right">Gurachek</p>
        <p class="text-center">Читайте <a href="http://blog.viebook.ru/" target="_blank">блог</a> проекта.
        </p>
    </div>
</footer>

<footer class="mobile-footer">
    <p class="text-center">Хотите следить за развитием пректа? Посетите наш <a href="http://blog.viebook.ru" target="_blank">блог</a></p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

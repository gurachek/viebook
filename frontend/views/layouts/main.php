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
    <meta name="google-site-verification" content="kjR3xvzotZkHnl8Y6NC4iF0XF_PUGrd8UMwLziGEenk" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="07e19644d4902619" />
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
    <div class="container-fluid promo" style="background: url(/images/promo-bg8.jpg) no-repeat; background-size: cover; color: #f6f6f6;">
        <br>
        <h3 class="text-center" style="margin: 0">Минутку внимания!</h3>
        <br>
        <div class="promo-text">
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
                <small style="color: #E64354; font-size: 12px; line-height: 0.5em;">* Мы не будем надоедать спамом. Только полезная для Вас информация.</small>
            </div>  
            <div class="ty_for_email">
                <span class="glyphicon glyphicon-ok"></span>
                 Спасибо за доверие, ожидайте рассылку
            </div>   
        </div>
        <div class="close-promo" style="margin-bottom: 10px; color: #444;">
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

<footer class="footer" style="padding: 0;border-top: 1px solid #d2d2d2;">
    <div style="background: #e9e9e9;">
    <div class="container" style="color: #444 !important;background: #e9e9e9; ">
        <br>
        <div class="row">
            <div class="col-md-4 text-center">
                <p class="text-left">
                    <a href="http://viebook.ru/site/about" style="color: #444 !important;">О проекте</a>
                    <br>
                    <a href="http://blog.viebook.ru/" target="_blank" style="color: #444 !important;">Блог</a>
                    <br>
                    <a href="https://spark.ru/startup/viebook" target="_blank" style="color: #444 !important;">Мы на спарке</a>
                </p>
            </div>
            <div class="col-md-4 text-center">
                <!-- <script type="text/javascript">
                document.write("<a href='//www.liveinternet.ru/click' "+
                "target=_blank><img src='//counter.yadro.ru/hit?t44.6;r"+
                escape(document.referrer)+((typeof(screen)=="undefined")?"":
                ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                ";"+Math.random()+
                "' alt='' title='LiveInternet' "+
                "border='0' width='31' height='31'><\/a>")
                </script> -->
            </div>
            <div class="col-md-4">
                &copy; Viebook <?= date('Y') ?>. All rights reserved.
                <br>
                По всем вопросам: <a href="mailto:vgurachek@gmail.com">gurachek@viebook.ru</a>   
            </div>
        </div>
    </div>
    </div>
</footer>

<footer class="mobile-footer">
    <p class="text-center">Хотите следить за развитием пректа? Посетите наш <a href="http://blog.viebook.ru" target="_blank">блог</a></p>
    <p class="text-right">
            <!-- <script type="text/javascript">
            document.write("<a href='//www.liveinternet.ru/click' "+
            "target=_blank><img src='//counter.yadro.ru/hit?t44.6;r"+
            escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
            screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
            ";"+Math.random()+
            "' alt='' title='LiveInternet' "+
            "border='0' width='31' height='31'><\/a>")
            </script> -->
    </p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Modal;

$url = Yii::$app->getUrlManager()->createAbsoluteUrl(['site/opinion']);

$customJs = <<<JS

jQuery(document).ready(function () {

    if (!$.session.get('promo_closed')) {
        jQuery('.promo').css('display', 'block');
    }    
    
    jQuery('.close-promo .sure').click(function () {
        jQuery('.promo').css('display', 'none');
        $.session.set('promo_closed', true);
    });

    if ($.session.get('design_opinion')) {
        jQuery('.opinion').css('display', 'none');
    }    
    
    jQuery('.opinion .opinion-button').click(function () {

        var id = jQuery(this).data('id');

        $.ajax({
            url: '$url',
            data: {
                'id': id,
            },
            method: 'POST',
            success: function (data) {
                if (data) {
                    alert(true);
                }
            },
        });

        jQuery('.ty_for_opinion').css('display', 'block');
        jQuery('.ty_for_opinion').fadeOut(2200);
        $.session.set('design_opinion', true);
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
    <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5a564e0b60405000131c1b4c&product=inline-share-buttons"></script>
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

    // $leftMenu = [
    //     ['label' => 'Книги', 'url' => ['/book/list']],
    // ];

    // $leftMenu[] = ['label' => 'Авторы', 'url' => ['/author/list']];
    // $leftMenu[] = ['label' => 'Пользователи', 'url' => ['/user/list']];

    $leftMenu = [
        ['label' => 'Books', 'url' => ['/book/list']],
    ];

    $leftMenu[] = ['label' => 'About', 'url' => ['/site/about']];
    //$leftMenu[] = ['label' => 'DONATE', 'url' => ['/site/donate']];

    // if (Yii::$app->user->can('godmode'))
    //     $leftMenu[] = ['label' => '!', 'url' => ['/god/index']];

     echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenu,
    ]);

    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Sign up', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Sign in', 'url' => ['/site/login']];
    } else {

        Html::a('<span class="glyphicon glyphicon-pencil"></span> Publish',
                    ['/search/mycomment'], 
                    [
                        'title' => 'View Feed Comments',
                        'data-toggle'=>'modal',
                        'data-target'=>'#modalvote',
                    ]
                   );

        $menuItems[] = '<li>'
        .Html::a('&nbsp;<span class="glyphicon glyphicon-pencil"></span> Publish &nbsp;',
                    ['/app/find-book'], 
                    [
                        'class' => 'btn write-review',
                        'style' => 'padding: 5px; margin-top: 10px;',
                        'title' => 'Find book',
                        'data-toggle'=>'modal',
                        'data-target'=>'#modalvote',
                    ])
        .'</li>';

        // $menuItems[] = ['label' => 'Фид-лента', 'url' => ['feed/index']] ;

        $menuItems[] = '<li class="user-name" style="cursor: pointer; margin-top: 14px; margin-left: 10px;">'
        . Yii::$app->user->identity->getName()
        .'</li>';


        $menuItems[] = '<li id="user-name_lnk">'
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

    <div class="modal remote fade" id="modalvote">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

    <div class="free-space"></div>

    <div class="ty_for_opinion">
        Спасибо!
    </div>

    <div class="opinion" style="margin-bottom: 20px; width: 100%; text-align: center;">
         <p>Вам нравится новый дизайн?</p>
         <button class="opinion-button btn btn-success" data-id="1">Да</button>
         <button class="opinion-button btn btn-danger" data-id="0">Нет</button>
    </div>

    <?php if (!Yii::$app->user->getId()): ?>

    <div class="container-fluid promo" style="background: url(/images/promo-bg9.jpg) no-repeat; background-size: cover; color: #f6f6f6; margin-top: -14px;background-attachment: fixed; margin-bottom: 15px;">
        <br>
        <h3 class="text-center" style="margin: 0">Минутку внимания!</h3>
        <br>
        <div class="promo-text">
            <h4>Что такое Viebook?</h4>

            <p>
                Сервис, создающий для Вас персональный план развития в выбранной сфере с помощью книг. Мы используем алгоритм, который учитывает Ваши интересы, опыт работы, цели, генерирует список книг и предоставляет обзоры книг. 
            </p>

            <br>

            <h4>Зачем нужны обзоры?</h4>

            <p>
                Обзоры объясняют основные идеи, кому стоит прочитать книгу, рассматривают примеры из книг, расписывают применимо ли это у нас (СНГ). 
                <br>
                Цель обзоров - ответить на два основных вопроса. Стоит ли читать данную книгу конкретно Вам и что конкретно вы получите после прочтения.
            </p>

            <br>

            Сейчас на главной странице вы видите тестовые обзоры, которые добавлены, чтобы показать как это работает. Мы ищем людей, которые будут готовы уделить время написанию обзоров. Если вы хотите присоединиться и помочь развитию сайта - пишите на <a href="mailto:vgurachek@gmail.com" style="color: #eee777;">vgurachek@gmail.com</a>.<br>

            <br>
            <br>
            <p class="text-center">Сайт ориентирован на три направления деятельности</p>
            <br>
            <div class="row">
                <div class="col-md-4 text-center" style="padding-bottom: 20px;">
                    <?= Html::a('<img src="/images/code.png" width="150" height="150">', ['/category/', 'id' => 1]) ?>
                    <br>
                    <h3>Программирование</h3>
                </div>
                <div class="col-md-4 text-center" style="padding-bottom: 20px;">
                    <?= Html::a('<img src="/images/design.png" width="150" height="150">', ['/category/', 'id' => 2]) ?>
                    <br>
                    <h3>Дизайн</h3>
                </div>
                <div class="col-md-4 text-center">
                    <?= Html::a('<img src="/images/business.png" width="150" height="150">', ['/category/', 'id' => 3]) ?>
                    <br>
                    <h3>Бизнес</h3>
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?= Html::a('Бесплатная регистрация', ['site/signup'], ['class' => 'btn viebutton', 'style' => 'float: none; margin-top: -40px;']) ?>
                    
                </div>
            </div>
        </div>
        <br>
        <div class="close-promo" style="margin-bottom: 10px; color: #444;">
            <a style="color: whitesmoke !important; text-decoration: underline;" class="sure">Закрыть</a>
        </div>
    </div>

    <?php endif; ?>

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
            <div class="col-md-4 text-center"></div>
            <div class="col-md-4">
                &copy; Viebook <?= date('Y') ?>. All rights reserved.
                <br>
                По всем вопросам: <a href="mailto:vgurachek@gmail.com">vgurachek@gmail.com</a>   
            </div>
        </div>
    </div>
    </div>
</footer>

<footer class="mobile-footer">
    <p class="text-center">Хотите следить за развитием пректа? Посетите наш <a href="http://blog.viebook.ru" target="_blank">блог</a></p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

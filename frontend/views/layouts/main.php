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

    // if ($.session.get('design_opinion')) {
        jQuery('.opinion').css('display', 'none');
    // }    
    
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
                    jQuery('.opinion').hide();

                    jQuery('.ty_for_opinion').css('display', 'block');
                    jQuery('.ty_for_opinion').fadeOut(2200);

                    $.session.set('design_opinion', true);
                }
            },
        });
    });

    jQuery('.opinion .op-close').click(function () {
        jQuery('.opinion').hide();
        $.session.set('design_opinion', true);
    });

    jQuery('.search-icon').click(function () {
        jQuery('.search-input-block').fadeIn(500);
    });

    jQuery('.search-input-block').click(function() {
    
        jQuery('.search-input-block').fadeOut(500);
        jQuery('form#search-form:first').focus();

    }).children().click(function(e) {
    
      return false;
   
    });

    var lastScrollTop = 0;
    $(window).scroll(function (event) {
        var st = $(this).scrollTop();
        
        if (st > lastScrollTop){
        
            // downscroll code
        
        } else {
        
            // upscroll code
        
        }

        lastScrollTop = st;
    });

    jQuery('.search').keyup(function (event) {
        jQuery('.search-content').delay(300).fadeIn(1600);
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
<?php if (trim(Yii::$app->getUrlManager()->createAbsoluteUrl(['/'])) != 'http://vie.local/'): ?>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PTWNVMK');</script>
    <!-- End Google Tag Manager -->

<?php endif; ?>

    <link rel="alternate" href="https://viebook.ru" hreflang="ru-RU" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="07e19644d4902619" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <meta name="google-site-verification" content="Rk-U-fzLha7dGP0kyRnzatleu8xBBfBP0xcYSG6Lajs" />
    <link href="/images/favicon.ico" rel="icon" type="image/x-icon" />
    <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5a564e0b60405000131c1b4c&product=inline-share-buttons"></script>
</head>
<body>
<?php $this->beginBody() ?>

<span class="icon-a"></span>

<?php if (trim(Yii::$app->getUrlManager()->createAbsoluteUrl(['/'])) != 'http://vie.local/'): ?>
    
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTWNVMK"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-106045460-1', 'auto');
      ga('send', 'pageview');

    </script>
<?php endif; ?>

<div class="search-input-block">
    <div class="row">
        <div class="col-md-8 col-md-offset-3 col-xs-11 col-xs-offset-1">
            <form name="search-form" id="searchform" class="search-form">

                <div style="width: 80%; float: left; padding-right: 5px;">
                    <input type="text" name="search" class="form-control search" placeholder="Начните вводить название книги...">
                </div>

                <button type="submit" class="btn viebutton"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>

            </form>
        </div>
    </div>
    <div class="row search-content">
        <div class="col-md-12">
            <br>
            <br>
            <br>
            <h3 class="text-center" style="color: white;">Сайт только наполняется контентом.</h3>
        </div>
    </div>
</div>

<div class="wrap" style="margin-top: 5px;">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/images/logo.png" width="40" height="40" style="margin-top: -9px; float: left;">
            <img src="/images/logo_text.svg" width="130" height="30" style="margin-top: -7px; float: right;">',
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
        ['label' => 'Книги', 'url' => ['/books']],
    ];

    $leftMenu[] = ['label' => 'О проекте', 'url' => ['/about']];
    
    $leftMenu[] = '<li>'
    .'<a class="search-icon" href="#search">'
    .'<span class="glyphicon glyphicon-search"></span>'
    .'</a>'
    .'</li>';
    
    //$leftMenu[] = ['label' => 'DONATE', 'url' => ['/site/donate']];

    // if (Yii::$app->user->can('godmode'))
    //     $leftMenu[] = ['label' => '!', 'url' => ['/god/index']];

     echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $leftMenu,
    ]);

    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Зарегистрироваться', 'url' => ['/signup'], 'options' => ['class' => 'signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/login']];
    } else {

        Html::a('<span class="glyphicon glyphicon-pencil"></span> Написать',
                    ['/search/mycomment'], 
                    [
                        'title' => 'View Feed Comments',
                        'data-toggle'=>'modal',
                        'data-target'=>'#modalvote',
                    ]
                   );

        $menuItems[] = '<li>'
        .Html::a('&nbsp;<span class="glyphicon glyphicon-pencil"></span> Написать &nbsp;',
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
        .'<a href="'. Yii::$app->getUrlManager()->createAbsoluteUrl(['/me']) .'" style="width: 30px; height: 30px;">'
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

    <div class="opinion">
         <p>
             Оцените, пожалуйста, новый дизайн
             <br>
             <span class="opinion-button" data-id="1">
                <span class="glyphicon glyphicon-heart-empty" style="color: #ececec; font-size: 20px; margin-right: 15px; cursor: pointer;"></span>
             </span>
             <span class="opinion-button" data-id="0">
                 <span class="glyphicon glyphicon-thumbs-down" style="color: #ececec; font-size: 20px; margin-right: 15px; cursor: pointer;"></span>
             </span>
         </p>
         <p class="op-close" style="position: absolute; right: 10px; bottom: 2px; border-radius: 100px; border: 1px solid #ececec; padding: 4px 7px; cursor: pointer;">
             <span class="glyphicon glyphicon-remove"></span>
         </p>
    </div>

    <?php if (!Yii::$app->user->getId()): ?>

    <div class="container-fluid promo" style="background: url(/images/promo-bg9.jpg) no-repeat; background-size: cover; color: #f6f6f6; margin-top: -14px;background-attachment: fixed; margin-bottom: 15px; display: none;">
        <br>
        <br>
        <h3 class="text-center" style="margin-top: 20px;">Платформа для создания персонализированного пути развития в выбранной сфере</h3>
        <br>
        <div class="promo-text">
            
            Сервис создает для вас и корректирует в процессе изучения план развития на основе ваших интересов, характера, способности обучаться. Помогает с дисциплиной и отслеживает прогрес при изучении. 

            <br>
            <br>

            <p class="text-center">Сайт ориентирован на три направления деятельности</p>
            <br>
            <div class="row">
                <div class="col-md-4 text-center" style="padding-bottom: 20px;">
                    <?= Html::a('<img src="/images/code.png" width="100" height="100">', ['/category/index', 'id' => 1]) ?>
                    <br>
                    <h4>Программирование</h4>
                </div>
                <div class="col-md-4 text-center" style="padding-bottom: 20px;">
                    <?= Html::a('<img src="/images/design.png" width="100" height="100">', ['/category/index', 'id' => 2]) ?>
                    <br>
                    <h4>Дизайн</h4>
                </div>
                <div class="col-md-4 text-center">
                    <?= Html::a('<img src="/images/business.png" width="100" height="100">', ['/category/index', 'id' => 3]) ?>
                    <br>
                    <h4>Бизнес</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                    <?= Html::a('Попробовать бесплатно', ['site/signup'], ['class' => 'btn', 'style' => 'background: #E64354; float: none; margin-top: -40px; color: white;']) ?>
                    
                </div>
            </div>
        </div>
        <div class="close-promo" style="margin-bottom: 10px; color: #444;">
            <a style="color: whitesmoke !important; text-decoration: underline;" class="sure">Закрыть</a>
        </div>
    </div>

    <?php endif; ?>

    <div class="container layout">
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
                    <a href="http://blog.viebook.ru/" target="_blank" style="color: #444 !important;">Блог</a>
                    <br>
                    <a href="http://viebook.ru/pricing" target="_blank" style="color: #444 !important;">Цены</a>
                </p>
            </div>
            <div class="col-md-4 text-center"></div>
            <div class="col-md-4">
                &copy; Viebook <?= date('Y') ?>. Ол райтс ресёрвд.
                <br>
                Писать сюда: <a href="mailto:vgurachek@gmail.com">contact@viebook.ru</a> 
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

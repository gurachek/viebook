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
        console.log(this);
        jQuery('.search-input-block').fadeOut(500);
    }).children().click(function(e) {
      return false;
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
<body style="background: url(/images/promo-bg9.jpg) no-repeat; background-size: cover;background-attachment: fixed; padding-top: 10px;">
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

<div class="wrap" style="margin-top: 5px;">

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="/">
                    <img src="/images/book.png" width="100" height="100">
                </a>
            </div>
        </div>
    </div>
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
                    <a href="http://blog.viebook.ru/" target="_blank" style="color: #444 !important;">Blog</a>
                    <br>
                    <a href="http://viebook.ru/site/pricing" target="_blank" style="color: #444 !important;">Pricing</a>
                </p>
            </div>
            <div class="col-md-4 text-center"></div>
            <div class="col-md-4">
                &copy; Viebook <?= date('Y') ?>. All rights reserved.
                <br>
                Send us feedback: <a href="mailto:vgurachek@gmail.com">contact@viebook.ru</a> 
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

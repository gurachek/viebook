<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $review->title .' - "'. $review->book->name .'" '. $review->book->author->name ;

// For estimate
$url = Yii::$app->getUrlManager()->createAbsoluteUrl(['review/estimate']);
$bookVisitUrl = Yii::$app->getUrlManager()->createAbsoluteUrl(['book/visit']);
$reviewViewUrl = Yii::$app->getUrlManager()->createAbsoluteUrl(['review/ajax-view']);
$userId = Yii::$app->user->getId() ?? 0;
$reviewId = $review->id;

$authJS = <<< JS

// Counter for views

jQuery.ajax({
    url: "$reviewViewUrl",
    method: "GET",
    data: {
        reviewId: {$review->id},    
    },
    success: function (data) {

    },
});

// Sending data about user visit

jQuery.ajax({
    url: "$bookVisitUrl",
    method: "GET",
    data: {
        bookId: {$review->book->id},
    },
    success: function (data) {

    },
});

// Estimate review

jQuery(document).ready(function () {
    jQuery('.estimate .like').css('cursor', 'pointer');
    jQuery('.estimate .dislike').css('cursor', 'pointer');
    jQuery('.estimate span').click(function () {
        var id = parseInt(jQuery(this).data('id'));
        var isLeft = parseInt(jQuery(this).data('left'));

        var estimate_number = '.dislike-count';

        if (id == 1) {
            estimate_number = '.like-count';
        }

        jQuery('.estimate').addClass('estimate_opacity');
        jQuery(this).addClass('estimate_rotate');

        jQuery.ajax({
            url: "$url",
            method: "POST",
            data: {
                userId: $userId,
                reviewId: $reviewId,
                estimate: id,
            },
            success: function (data) {
                if (!data) {

                    jQuery('.ty_for_estimate').css('background', 'rgba(0, 0, 0, 0.9)');
                    jQuery('.ty_for_estimate .text').html('<span class="glyphicon glyphicon-remove-sign"> </span>&nbsp;&nbsp;Вы уже оценивали эту рецензию');
                
                    console.log(isLeft);

                    if (isLeft != 1) {
                        jQuery('.estimate').css('display', 'none');
                    }
                    

                } else {

                    var number = parseInt(jQuery(estimate_number).html());
                    number += 1;
                    jQuery(estimate_number).html(number + ' ');

                    if (isLeft != 1) {
                        jQuery('.estimate').css('display', 'none');
                    }
                }

                jQuery('.ty_for_estimate').css('display', 'block');
                jQuery('.estimate').removeClass('estimate_opacity');
                jQuery('.estimate span').removeClass('estimate_rotate');

                jQuery('.ty_for_estimate').css('opacity', '1');

                jQuery('.ty_for_estimate').animate({'opacity':'0.1'}, 1800, function () {
                    jQuery('.ty_for_estimate').slideUp(450);
                    jQuery('.estimate').css('display', 'block');
                });
            },
        });
    });
});

JS;

$customJS = <<<JS

// Display promo block after page scrolled book block

if (window.innerWidth >= 991) {

    jQuery(document).scroll(function() {
        var el = $('.lolkek');  //record the elem so you don't crawl the DOM everytime  
        var bottom = el.position().top + el.outerHeight(true);

        if (bottom >= 900) {
            jQuery('.lolkek').css('display', 'block');
        }
    });

}

jQuery('.navbar-inverse').removeClass('navbar-fixed-top');
jQuery('.main-block').removeClass('container');
jQuery('.main-block').addClass('container-fluid');
jQuery('.container-fluid').removeClass('main-block');

jQuery('.navbar-inverse').addClass('navbar-default navbar-static-top');
jQuery('.free-space').css('height', '0');
jQuery('.wrap').css('margin-top', '0');

var arrow_pos = jQuery(window).height() - 150;

jQuery('.top-arrow').css('position', 'fixed');
jQuery('.top-arrow').css('top', arrow_pos);
jQuery('.top-arrow').css('top', '30');

$('.top-arrow').click(function() {
    $('html, body').animate({scrollTop: 0},500);
    return false;
  })

window.onscroll = function() {
  var scrolled = window.pageYOffset || document.documentElement.scrollTop;
  if (scrolled >= 200) {
  	jQuery('.top-arrow').css('display', 'block');
  } else {
  	jQuery('.top-arrow').css('display', 'none');
  }
}

JS;

$nonauthJS = <<<JS

jQuery(document).ready(function () {
    jQuery('.estimate .like').css('cursor', 'pointer');
    jQuery('.estimate .dislike').css('cursor', 'pointer');
    jQuery('.estimate span').click(function () {
        alert("Вам нужно авторизоваться, чтобы оценить обзор.");
    });
});

JS;

if (Yii::$app->user->getId()) $this->registerJs($authJS);
else $this->registerJs($nonauthJS);

$this->registerJs($customJS);

$positive = !empty($review->estimates) ? @$review->estimates[0]->numberOfPositive() : 0;
$negative = !empty($review->estimates) ? @$review->estimates[0]->numberOfNegative() : 0;

?>

<div class="row review_page">
	<div class="col-md-1 text-center">
		<div class="social-buttons" style="margin-top: 10px; position: fixed; left: 30px;">
			<ul id="estimate_left" class="list-unstyled social-button-item estimate">
				<li>
                    <span class="like" data-id="1" data-left="1">
					<img src="/images/like.ico" width="40" height="40" style="margin-bottom: 5px;">
                    </span>
                    <br>
                    <span class="like-count" style="color: #444; font-size: 16px; margin-left: -10px;"><?= $positive ?></span>
				</li>
				<li>
                    <span class="dislike" data-id="0" data-left="1">
					<img src="/images/dislike.png" width="40" height="40" style="margin-bottom: 5px;">
                    </span>
                    <br>
                    <span class="dislike-count" style="color: #444; font-size: 16px; margin-left: -10px;"><?= $negative ?></span>
				</li>
			</ul>
		</div>
		<div class="top-arrow" title="Наверх">
				<span class="glyphicon glyphicon-menu-up"></span>
		</div>
	</div>
    <div class="col-md-7 review_text">

        <ul class="list-inline" style="color: gray;">
            <li class="display_on_mobile_book_block">
                <span class="glyphicon glyphicon-book"></span>
                <?= Html::a($review->book['name'], ['book/view', 'id' => $review->book['id']]) ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-user"  title="Автор рецензии"></span>
                <?= Html::a($review->author->getName(), ['user/view', 'id' => $review->author->id]) ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-menu-hamburger" title="Категория"></span>
                <?= Html::a($review->book->cat['name'], ['category/index', 'id' => $review->book->cat['id']]) ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-calendar"  title="Дата написания"></span>
                <?php
                    Yii::$app->formatter->locale = 'ru-RU';
                    echo Yii::$app->formatter->asDate($review->created_at, 'long'); 
                ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-eye-open"  title="Просмотры"></span>
                <?= $review->views ?>
            </li>
        </ul>

        <h3><?= $review->title ?>
            <?php if (Yii::$app->user->getId() == $review->author['id']): ?>
            <?= Html::a('
            <small title="Редактировать" style="color: gray;">
                <span class="glyphicon glyphicon-edit"></span>
            </small>', ['review/edit', 'id' => $review->book['id']]) ?>
            <?php endif; ?>
        </h3>
        
        <p style="font-size: 17px; line-height: 1.6em;">
            Сегодня несколько слов о книге Джима Коллинза «От хорошего к великому». Это пожалуй, лучшая книга по бизнесу, среди всех, которые я читал. Она по-настоящему заслуживает права быть настольной. В какой то степени она даже не только о бизнесе. Не только о том, как построить успешную стабильную компанию, как набирать персонал или управлять проектами. Прежде всего она открывает глаза. Как на бизнес, так и на жизнь.
        </p>

        <br>
        	<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
			<script src="//yastatic.net/share2/share.js"></script>
			<div class="ya-share2" data-services="vkontakte,facebook,gplus,twitter"></div>
		<br>

        <div style="font-size: 17px; line-height: 1.6em;">
            <?= nl2br($review->text) ?>
        </div>

        <div class="ty_for_estimate text-center" role="alert">
            <span class="text">
                <span class="glyphicon glyphicon-ok-sign"></span>
                &nbsp;&nbsp;
                Спасибо за оценку
            </span>
        </div>

            <?php if (@$review->user_id != @$id): ?>

                <div class="estimate" style="text-align: center;">
                    <span class="like-count">
                        <?= $positive ?>
                    </span>
                    <span title="Понравилось" class="glyphicon glyphicon-heart-empty like" data-id="1"></span>
                    
                    <span class="dislike-count">
                        <?= $negative ?>
                    </span>
                    <span title="Не понравилось" class="glyphicon glyphicon-off dislike" data-id="0"></span>
                </div>

            <?php else: ?>
                <p class="text-center">
                <span style="color: gray;">
                    <?php if(!empty($review->estimates)): ?>
                        Положительных оценок: <?= $review->estimates[0]->numberOfPositive() ?>
                        <br>
                        Отрицательных оценок: <?= $review->estimates[0]->numberOfNegative() ?>
                    <?php else: ?>
                        У этой рецензии нет оценок
                    <?php endif; ?>
                </span>
                </p>
            <?php endif; ?>

            <br>
            <div class="signup-for-estimate text-center">
                <?= Html::a('Войдите, чтобы оценить рецензию', ['site/login', 'a' => 'review_view', 'id' => $review->id], ['class' => 'btn btn-success']); ?>
            </div>

        <?php if (@$review->user_id != @Yii::$app->user->getId()) { ?>
        <p>
            Думаете, что можете лучше?
            <?= Html::a("Напишите", ['review/write', 'bookid' => $review->book['id']], ['class' => '']); ?>
            свой обзор на данную книгу.
        </p>
        <?php } ?>

    </div>
    <div class="col-md-4 review_display_book_block">
        <div class="book_page" style="margin-bottom: 10px;">
            <div class="name">
                <h3 class="text-center"><?= $review->book->name ?></h3>
                <p class="text-center">
                    <span class="glyphicon glyphicon-user"  title="Автор книги"> </span> 
                    <?= Html::a($review->book->author->name, ['author/view', 'id' => $review->book->author->id]) ?>
                    &nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-scale"></span>
                     <?= Html::a($level->name, ['book/level', 'id' => $level->id, 'catid' => $review->book['category']], ['class' => 'text-center','style' => 'color: #444 !important;']) ?>
                </p>
                <div class="image" style="text-align: center;">
                    <div style="background: url(/images/books/<?= $review->book['image'] ?>) no-repeat; background-size: cover; width: 100%; height: 500px; background-position: center center;" title="<?= $review->book->name ?>"></div>
                    <hr width="80%">
                    <?= Html::a("Другие рецензии к этой книге", ['book/view', 'id' => $review->book['id']], ['class' => 'btn btn-lnk']); ?>
                </div>
            
            </div>
        
        </div>

        <div class="lolkek"></div>
    </div>
</div>

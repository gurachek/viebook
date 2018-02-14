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

				} else {

					var number = parseInt(jQuery(estimate_number).html());
					number += 1;
					jQuery(estimate_number).html(number + ' ');

				}

				jQuery('.ty_for_estimate').css('display', 'block');
				
				jQuery('.ty_for_estimate').css('opacity', '1');

				jQuery('.ty_for_estimate').animate({'opacity':'0.1'}, 2100, function () {
					jQuery('.ty_for_estimate').slideUp(450);
					jQuery('.estimate').css('display', 'block');
				});
			},
		});
	});
});

JS;

$customJS = <<<JS

jQuery('body').css('background', 'white');
jQuery('.book_page').css('background', '#fafafa');
jQuery('.book_page').addClass('shadow');

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

jQuery('.navbar-inverse').removeClass('navbar-fixed-top');
jQuery('.layout').removeClass('container');
jQuery('.layout').addClass('container-fluid');

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

  if (window.innerWidth >= 991) {
	  if (scrolled >= 700) {
		jQuery('.promo-block').show();
	  } else {
		jQuery('.promo-block').hide();
	  }                     
  } else {
  	jQuery('.social-buttons').hide();
  	
  	if (scrolled >= 350) {
  		jQuery('.estimate-mobile').show();
  	} else {
  		jQuery('.estimate-mobile').hide();
  	}
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
			<?= $review->preview ?>
		</p>

		<br>
		<div class="sharethis-inline-share-buttons"></div>
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

		<div class="estimate-mobile">
			<span title="Понравилось" class="glyphicon glyphicon-heart-empty like" data-id="1"></span><span class="like-count"><?= $positive ?></span>

			&nbsp;&nbsp;&nbsp;&nbsp;

			<span title="Не понравилось" class="glyphicon glyphicon-off dislike" data-id="0"></span><span class="dislike-count"><?= $negative ?></span>
		
			&nbsp;&nbsp;&nbsp;&nbsp;

			<span title="Закрепить" class="glyphicon glyphicon-pushpin pushpin"></span>
		</div>

		<br>

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

		<?php if (Yii::$app->user->isGuest): ?>

		<!-- <div class="" style="background: #f7f7f7;width:100%;margin: 0 auto; min-height: 370px;">
		<div class="text-right" style="padding-right: 7px; padding-top: 5px; color: gray;">
		<span class="glyphicon glyphicon-info-sign"></span> Advertisement by <u>Viebook</u></div>
		<div class="text-center">
		<img src="/images/logo.png" width="80" height="80" style="margin-top: 7px; margin-bottom: -15px;">
		</div>
		<h1 class="text-center" style="margin-bottom: -10px">Make more with less</h1>
		<h3 class="text-center">Just sign in and get powerfull advantages</h3>
		<p>
		<ul style="font-size: 16px; color: #444">
		<li>Feed list</li>
		<li>Design personalization</li>
		<li>Weekly email sending</li>
		</ul>
		</p>
		<div class="text-center">
		<?= Html::a('Sign up <span class="glyphicon glyphicon-new-window"></span>', ['/site/signup'], ['class' => 'btn btn-success']); ?>
		<br>
		<br>
		</div>
		</div> -->

		<?php endif; ?>

		</div>
	</div>
</div>

<div class="promo-block">
	<div class="text-right" style="background: rgba(250, 250, 250, 0.1);padding-right: 7px; padding-top: 5px; color: gray;">
	<span class="glyphicon glyphicon-info-sign"></span> Advertisement by <u>Viebook</u></div>
	<br>
	<div class="text-center">
		<img src="/images/book.png" width="80" height="80" style="margin-top: 7px; margin-bottom: -15px;">
	</div>
	<br>
	<h1 class="text-center" style="margin-bottom: -10px">Do more with less time</h1>
	<br>
	<h3 class="text-center">Just sign up and get powerfull advantages</h3>
	<br>
	<p>
		<ul class="list-unstyled" style="margin-left: 50px;font-size: 16px;">
			<li>
				<img src="https://cdn4.iconfinder.com/data/icons/office-equipment-flat-icons/512/news_media_paper_newspaper_office_equipment_business_object_flat_icon_symbol-512.png" width="70">
				&nbsp;&nbsp;&nbsp;
				Feed list
			</li>
			<br>
			<li>
				<img src="https://cdn4.iconfinder.com/data/icons/web-development/512/web_page_website_site_webpage_html_flat_icon_symbol-512.png" width="70">
				&nbsp;&nbsp;&nbsp;
				Design personalization
			</li>
			<br>
			<li>
				<img src="https://cdn3.iconfinder.com/data/icons/social-messaging-ui-color-shapes-2-1/254000/67-512.png" width="70">
				&nbsp;&nbsp;&nbsp;
				Weekly email sending</li>
		</ul>
	</p>
	<br>
	<div class="text-center">
		<?= Html::a('Sign up <span class="glyphicon glyphicon-new-window"></span>', ['/signup'], ['class' => 'btn btn-success']); ?>
	</div>
</div>

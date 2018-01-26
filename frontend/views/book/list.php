<?php
use yii\helpers\Html;

$this->title = "Cписок книг, доступных на Viebook";

$js = <<<JS

jQuery(document).ready(function () {
	jQuery('.image').hover(function () {
		jQuery('.image').css('background-size', 'contain');
	});
	jQuery('.image').on('mouseleave', function () {
		jQuery('.image').css('background-size', 'cover');
	});
});

JS;

$this->registerJS($js);
?>

<h3 class="text-center">Список всех книг, которые есть на сайте на данный момент</h3>
<br>

<?php if (!$books): ?>

	<p class="text-center">
			Я удалил все, чтобы заново загрузить только необходимые пользователям книги 
	</p>

<?php else: ?>

	<div class="row">

		<?php foreach($books as $book): ?>

			<div class="col-lg-3 col-md-4 col-xs-6" style="padding: 0px; margin: 0px;">
				
				<div class="book-list">
					<div class="short-info text-center">
						<span class="glyphicon glyphicon-pencil"></span>
						<?= count($book->reviews) ?>
						&nbsp;&nbsp;&nbsp;
						<span class="glyphicon glyphicon-tags"></span>
						<?= Html::a($book->cat['name'], ['/category', 'id' => $book->cat['id']]) ?>
						&nbsp;&nbsp;
						<span class="glyphicon glyphicon-scale"></span>
						<?= Html::a($book->level['name'], ['level', 'id' => $book->level['id'], 'catid' => $book->cat['id']]) ?>
					</div>
					<?= Html::a("
					<div title='{$book->name}' class='image' style='
						background: url(/images/books/{$book->image}) no-repeat;
	    				background-position: center center;
	    				background-size: cover;
    				'></div>", ['book/view', 'id' => $book->id]);
					?>
					<div class="title"><h3 class="text-center">Good to great</h3></div>
					<div class="view">
						<?php if (@$book->reviews[0]): ?>
							<span class="glyphicon glyphicon-link"></span>
							<?= Html::a('View best review', ['review/view', 'id' => $book->reviews[0]['id']]); ?>
						<?php else: ?>
							No reviews for this book yet.
						<?php endif; ?>
					</div>
				</div>

			</div>

		<?php endforeach; ?>

	</div>

<?php endif; ?>

<!-- <div class="col-lg-3 col-md-4 col-xs-6" style="padding: 0px; margin: 0px;">

<div class="" style="background: #ececec;width:95%;margin: 0 auto; min-height: 370px;">
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
<button class="btn btn-success">Sign up
<span class="glyphicon glyphicon-new-window"></span></button>
<br>
<br>
</div>
</div>

</div> -->
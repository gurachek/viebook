<?php
use yii\helpers\Html;

$this->title = "Ваш личный кабинет";

$js = <<<JS
	jQuery(document).ready(function() {
		jQuery('div .container').removeClass('main-block');
	});
JS;

$this->registerJs($js);

?>

<div class="row">
	<div class="col-md-3 col-md-push-9 main-block">
		<br>
		<div class="user_account_image" style="background: url(/images/users/<?= $user->image ?>) no-repeat center; background-size: cover;"></div>
		<div class="user_logout" title="Выход">
			<?= Html::beginForm(['/site/logout'], 'post') ?>
				<?= Html::submitButton('<span class="glyphicon glyphicon-log-out" style="color: #E64354;"></span>', ['class' => 'btn btn-link']) ?>
			<?= Html::endForm() ?>
			</div>
		<br>

		<p class="text-center" style="font-size: 17px;">
			<?= $user->getName(); ?>
			<br>
			<small style="color: gray;">Рейтинг: <?= $user->rating ?></small>
		</p>

		<ul class="user_menu">
		<li>
			<?= Html::a('Книги', ['user/index', 'content' => 'books']) ?>
			<?= Html::a('<span title="Добавить книгу" style="float: right;" class="glyphicon glyphicon-plus"></span>', ['book/add']) ?>
		</li>

		<li>
			<?= Html::a('Авторы', ['user/index', 'content' => 'authors']) ?>
			<?= Html::a('<span title="Добавить автора" style="float: right;" class="glyphicon glyphicon-plus"></span>', ['author/add']) ?>
		</li>

		<li>
			<?= Html::a('Мои обзоры', ['user/index', 'content' => 'reviews']) ?>
			<?= Html::a('<span title="Написать рецензию" style="float: right;" class="glyphicon glyphicon-plus"></span>', ['review/write']) ?>
		</li>
		<li><?= Html::a('Настройки', ['user/index', 'content' => 'settings']) ?></li>
		</ul>
	</div>
	<div class="col-md-9 col-md-pull-3">
		<!-- <div class="main-block about-user">
			Text about user
		</div> -->
		<div class="main-block" style="padding: 10px;">
			<?php
				if ($user->active) {
					echo $this->render('content-'.$content, ['data' => $data]);
				} else {
					echo $this->render('no-active-profile', ['email' => $user->email]);
				}
			?>
		</div>
	</div>
</div>

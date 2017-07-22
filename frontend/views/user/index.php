<?php
use yii\helpers\Html;

$this->title = "Ваш личный кабинет";

?>

<div class="row">
	<div class="col-md-12" >
		<ul class="list-unstyled list-inline" style="border: 1px solid #dedede; padding: 5px; background: white; padding-left: 10px;">
			<li>
			<span class="glyphicon glyphicon-pencil"></span>
			<?= Html::a('Написать рецензию', ['review/write']) ?>			
			</li>

			<li>
			<span class="glyphicon glyphicon-book"></span>
			<?= Html::a('Добавить книгу', ['book/add']) ?>
			</li>

			<li>
			<span class="glyphicon glyphicon-user"></span>
			<?= Html::a('Добавить автора', ['author/add']) ?>
			</li>

			<li style="padding: 0px;">
			<?= Html::beginForm(['/site/logout'], 'post') ?>
	        <?= Html::submitButton('<span class="glyphicon glyphicon-log-out"></span> Выход', ['class' => 'btn btn-link', 'style' => 'padding: 0;']) ?>
	        <?= Html::endForm() ?>
    		</li>
    	</ul>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-push-9">
		<br>
		<div class="user_account_image" style="background: url(/images/users/<?= $user->image ?>) no-repeat center; background-size: cover;"></div>
		<br>

		<p class="text-center" style="font-size: 17px;">
			<?= $user->getName(); ?>
			<br>
			<small style="color: gray;">Рейтинг: <?= $user->rating ?></small>
		</p>

		<ul class="user_menu">
		<li><?= Html::a('Мои добавленные книги', ['user/index', 'content' => 'books']) ?></li>
		<li><?= Html::a('Мои добавленные авторы', ['user/index', 'content' => 'authors']) ?></li>
		<li><?= Html::a('Мои рецензии', ['user/index', 'content' => 'reviews']) ?></li>
		<li><?= Html::a('Мои настройки', ['user/index', 'content' => 'settings']) ?></li>
		</ul>
	</div>
	<div class="col-md-9 col-md-pull-3">
		<?= $this->render('content_'.$content, ['data' => $data]); ?>
	</div>
</div>

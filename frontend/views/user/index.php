<?php
use yii\helpers\Html;

$this->title = "Ваш личный кабинет";

?>

<div class="row">
	<div class="col-md-12" style="border: 1px solid #dedede; padding: 5px; background: white; padding-left: 10px;">
		<span class="glyphicon glyphicon-pencil"></span>
		<?= Html::a('Написать рецензию', ['review/write']) ?>
		
		&nbsp;&nbsp;

		<span class="glyphicon glyphicon-book"></span>
		<?= Html::a('Добавить книгу', ['book/add']) ?>

		&nbsp;&nbsp;

		<span class="glyphicon glyphicon-user"></span>
		<?= Html::a('Добавить автора', ['author/add']) ?>
	</div>
</div>

<div class="row">
	<div class="col-md-9">
		<?= $this->render('content_'.$content, ['data' => $data]); ?>
	</div>
	<div class="col-md-3">
		<br>
		<div class="user_account_image" style="background: url(images/users/<?= $user->image ?>) no-repeat center; background-size: cover;"></div>
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
</div>

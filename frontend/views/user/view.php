<?php
use yii\helpers\Html;

$this->title = "Пользователь ". $user->getName();

?>

<div class="row">
	<div class="col-md-3 col-md-push-9 main-block">
		<div class="user_info">
			<br>
			<div class="user_account_image" style="background: url(/images/users/<?= $user->image ?>) no-repeat center; background-size: cover;"></div>
			<br>

			<p class="text-center" style="font-size: 17px;">
				<?= $user->getName(); ?>
				<br>
				<small style="color: gray;">Рейтинг: <?= $user->rating ?></small>
			</p>

			<ul class="user_menu">
			<li>Книг добавлено: <?= $booksAdded ?></li>
			<li>Авторов добавлено: <?= $authorsAdded ?></li>
			<li>Обзоров написано: <?= $reviewsWrote ?></li>
			</ul>
		</div>
	</div>
	<div class="col-md-9 col-md-pull-3">
		<?php if (!empty($user->about)): ?>
		
			<div class="main-block about-user">
				<p>О пользователе:</p>
				<?= Html::encode($user->about) ?>
			</div>

		<?php endif; ?>

		<div class="main-block" style="padding: 10px;">

			<?php if (!$user->reviews): ?>
				<h2 class="text-center">
					У пользователя нет опубликованных обзоров
				</h2>
			<?php else: ?>
				<h3>Последние обзоры:</h3>
			<?php endif; ?>

			<br>

			<?php foreach($user->reviews as $review): ?>
				<h4>
					<?= Html::a($review['title'], ['review/view', 'id' => $review['id']]) ?>
					<small>
						<span class="glyphicon glyphicon-menu-right"></span>
						<?= $review['book']['name'] ?>
					</small>
				</h4>

				<p style="color: gray;">
				Рейтинг: <?= $review['rating'] ?>
				</p>

				<p>
				<?php $text = intval(strlen($review['text']) / 5) ?>
				<?= mb_substr($review['text'], 0, $text, "utf-8") ?>...

				</p>
				<br>
			<?php endforeach; ?>

		</div>
	</div>
</div>

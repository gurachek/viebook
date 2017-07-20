<?php
use yii\helpers\Html;

$this->title = "Пользователь ". $user->getName();

?>

<div class="row">
	<div class="col-md-9">
		<?php if (!$user->reviews): ?>
			<h2 class="text-center">
				Пользователь не писал рецензий
			</h2>
		<?php else: ?>
			<h3>Последние рецензии:</h3>
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
			<?php $text = intval(strlen($review['text']) / 3) ?>
			<?= mb_substr($review['text'], 0, $text, "utf-8") ?>...
			
			</p>
			<br>
		<?php endforeach; ?>
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
		<li>Книг добавлено: <?= $booksAdded ?></li>
		<li>Авторов добавлено: <?= $authorsAdded ?></li>
		<li>Рецензий написано: <?= $reviewsWrote ?></li>
		</ul>
	</div>
</div>

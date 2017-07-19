<?php
use yii\helpers\Html;

$this->title = "Ваш личный кабинет";

?>

<div class="row">
	<div class="col-md-12">
		<h2 class="text-center">Рецензии, которые Вы написали</h2>
		<br>
		<?php foreach($user->reviews as $review): ?>
			<h4>
				<?= Html::a($review['title'], ['review/view', 'id' => $review['id']]) ?>
				<small>
					<span class="glyphicon glyphicon-menu-right"></span>
					<?= $review['book']['name'] ?>
				</small>
			</h4>
			<p>
				Рейтинг: <?= $review['rating'] ?>
			</p>
			<p>
				<?php $text = intval(strlen($review['text']) / 5) ?>
                <?= mb_substr($review['text'], 0, $text, "utf-8") ?>...
                <p class="text-right">
                	<span class="glyphicon glyphicon-pencil"></span>
                	<?= Html::a('Редактировать', ['review/edit', 'id' => $review['id']]) ?>
                	
                	&nbsp;&nbsp;
                	
                	<span class="glyphicon glyphicon-remove"></span>
                	<?= Html::a('Удалить', ['review/delete', 'id' => $review['id']]) ?>
                </p>
			</p>
			<br>
		<?php endforeach; ?>
	</div>
</div>

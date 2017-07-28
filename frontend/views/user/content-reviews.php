<?php
use yii\helpers\Html;
?>
<h2 class="text-center">Ваши рецензии</h2>

<?php if (!$data->reviews): ?>
	<p class="text-center">
		У Вас нет активных рецензий
	</p>
<?php endif; ?>
<br>
<?php foreach($data->reviews as $review): ?>
	<h4>
		<?= Html::a($review['title'], ['review/view', 'id' => $review['id']]) ?>
		<small>
			<span class="glyphicon glyphicon-menu-right"></span>
			<?= $review['book']['name'] ?>
		</small>
	</h4>

	<?php if ($review->active): ?>
		<p style="color: gray;">
			Рейтинг: <?= $review['rating'] ?>
		</p>
	<?php else: ?>
		<p style="color: orange;">
			<span class="glyphicon glyphicon-exclamation-sign"></span>
			На модерации
		</p>
	<?php endif; ?>

	<p>
		<?php $text = intval(strlen($review['text']) / 5) ?>
        <?= mb_substr($review['text'], 0, $text, "utf-8") ?>...
        <p class="text-right">
        	<span class="glyphicon glyphicon-pencil"></span>
        	<?= Html::a('Редактировать', ['review/edit', 'id' => $review['book']['id']]) ?>
        	
        	&nbsp;&nbsp;
        	
        	<span class="glyphicon glyphicon-remove"></span>
        	<?= Html::a('Удалить', ['review/delete', 'id' => $review['book']['id']]) ?>
        </p>
	</p>
	<br>
<?php endforeach; ?>
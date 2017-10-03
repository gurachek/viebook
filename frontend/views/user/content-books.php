<?php
use yii\helpers\Html;
?>

<h2 class="text-center">Книги</h2>

<?php if (!$data): ?>
	<p class="text-center">
		Вы не добавляли книги на сайт
	</p>
<?php endif; ?>
<br>

<?php foreach($data as $book): ?>
	<div class="book_in_list">
		<?= Html::a("<div class='image'
		title='". $book['name'] ."'
		style='background: url(/images/books/". $book['image'] .")
		no-repeat center; background-size: contain;'></div>",
		['book/view', 'id' => $book['id']]) ?>
	</div>
<?php endforeach; ?>
<div class="clear_after_block">
</div>
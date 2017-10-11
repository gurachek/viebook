<?php
use yii\helpers\Html;

$this->title = "Cписок книг, доступных на Viebook";
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
				<?= Html::a("
				<div title='{$book->name}' style='background: url(/images/books/{$book->image}) no-repeat center; background-size: contain; width: 190px; height: 190px;margin-bottom: 20px;'>
				</div>", ['book/view', 'id' => $book->id]);
				?>
			</div>

		<?php endforeach; ?>

	</div>

<?php endif; ?>


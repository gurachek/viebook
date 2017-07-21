<?php
use yii\helpers\Html;

$this->title = "Cписок книг, доступных на Viebook";
?>

<h3 class="text-center">Список всех книг, которые есть на сайте на данный момент</h3>
<br>

<div class="row">

	<?php foreach($books as $book): ?>

		<div class="col-lg-2 col-md-3 col-ls-4 col-xs-6">
			<?= Html::a("
			<div title='{$book->name}' style='background: url(/images/books/{$book->image}) no-repeat center; background-size: contain; width: 200px; height: 200px;margin-bottom: 20px;'>
			</div>", ['book/view', 'id' => $book->id]);
			?>
		</div>

	<?php endforeach; ?>

</div>

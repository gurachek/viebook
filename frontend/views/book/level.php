<?php
use yii\helpers\Html;

$title = 'Все книги уровня "'. $level->name .'"';

if ($category) {
	$title .= ' категории "'. $category->name .'"';
}

$title .= ' на Viebook';

$this->title = $title;

?>

<h3 class="text-left">
	<?= $level->name ?>
	<small>
		<span class="glyphicon glyphicon-chevron-right"></span> 
		<?= Html::a($category->name, ['category/index', 'id' => $category->id]) ?>
	</small>
</h3>

<p><?= $level->description ?></p>
<br>

<?php if ($books): ?>

	<?= $this->render('/parts/_book', ['books' => $books]) ?>

	<?php else: ?>

	<h4>На сайте нет подходящих книг</h4>

<?php endif; ?>
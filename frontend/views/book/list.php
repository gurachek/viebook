<?php
use yii\helpers\Html;

$this->title = "Cписок книг, доступных на Viebook";

$js = <<<JS

jQuery(document).ready(function () {
	jQuery('.image').hover(function () {
		jQuery(this).css('background-size', 'contain');
	});
	jQuery('.image').on('mouseleave', function () {
		jQuery(this).css('background-size', 'cover');
	});
	
	jQuery('.free-space').css('margin-top', '-20px');
});

JS;

$this->registerJS($js);
?>

<h3>Список всех книг, которые есть на сайте на данный момент</h3>
<div class="orange-line"></div>

<?php if (!$books): ?>

	<p class="text-center">
			На сайте нет книг 
	</p>

<?php else: ?>

	<?= $this->render('/parts/_book', ['books' => $books]); ?>

<?php endif; ?>
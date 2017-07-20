<?php
use yii\helpers\Html;

$this->title = "Удаление рецензии";
?>

<h4 class="text-center">Вы не можете удалить свою рецензию на эту книгу, так как не писали ее</h4>
<p class="text-center">
	<?= Html::a('Написать', ['review/write', 'bookid' => $id], ['class' => 'btn btn-default']) ?>
</p>
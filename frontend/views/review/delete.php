<?php
use yii\helpers\Html;

$this->title = "Удаление рецензии";
?>
<h3 class="text-center">Вы действительно хотите удалить свою рецензию?</h3>

<p class="text-center">
	<?= Html::a('Да, действительно', ['review/delete', 'id' => $id, 'sure' => '1'],['class' => 'btn btn-default']) ?>
</p>
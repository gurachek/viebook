<?php
use yii\helpers\Html;
$this->title = "В адресной строке отсутствует идентификатор автора";
?>
<h4 class="text-center">В адресной строке отсутствует идентификатор автора</h4>
<p class="text-center">
	Посмотрите 
	<?= Html::a('как это должно быть', ['author/view', 'id' => '1']) ?>
</p>
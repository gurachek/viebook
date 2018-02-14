<?php
use yii\helpers\Html;
$this->title = "В адресной строке отсутствует идентификатор рецензии";
$this->registerJs("jQuery('.layout').addClass('main-block')");
?>
<h4 class="text-center">В адресной строке отсутствует идентификатор рецензии</h4>
<p class="text-center">
	Посмотрите 
	<?= Html::a('как это должно быть', ['review/view', 'id' => '1']) ?>
</p>
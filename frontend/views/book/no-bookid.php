<?php
use yii\helpers\Html;
$this->title = "В адресной строке отсутствует идентификатор книги";

$this->registerJs("jQuery('.layout').addClass('main-block')");

?>
<h4 class="text-center">В адресной строке отсутствует идентификатор книги</h4>
<p class="text-center">
	Начните свое путешествие по сайту с
	<?= Html::a('поиска нужной книги', ['app/index']) ?>
</p>
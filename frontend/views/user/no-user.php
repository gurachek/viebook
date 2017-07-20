<?php
use yii\helpers\Html;
$this->title = "На сайте нет такого пользователя";
?>
<h4 class="text-center">На сайте нет такого пользователя</h4>
<p class="text-center">
	Вот как выглядит
	<?= Html::a('аккаунт пользователя', ['user/view', 'id' => '1']) ?>
</p>
<?php
use yii\helpers\Html;

$this->title = "Восстановление пароля";
$this->registerJs("jQuery('.layout').addClass('main-block')");
?>
<br>
<p class="text-center">
	Пользователь с таким email-адресом не зарегистрирован на сайте.
	<br>
	<br>
	<?= Html::a('Регистрация', ['site/signup'], ['class' => 'btn btn-default']) ?>
</p>
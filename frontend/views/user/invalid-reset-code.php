<?php
use yii\helpers\Html;

$this->title = "Неверный код восстановления пароля";
$this->registerJs("jQuery('.layout').addClass('main-block')");
?>
<br>
<p class="text-center">
	Неверный код восстановления пароля. Попробуйте еще раз
	<br>
	<br>
	<?= Html::a('Восстановить пароль', ['site/reset-password-request'], ['class' => 'btn btn-default']) ?>
</p>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Новый пароль установлен';
$this->registerJs("jQuery('.layout').addClass('main-block')");
?>
<br>
<p class="text-center">Новый пароль установлен</p>
<br>
<p class="text-center">
<?= Html::a('Войти', ['site/login'], ['class' => 'btn btn-default']) ?>
</p>
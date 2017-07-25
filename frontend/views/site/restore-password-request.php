<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Восстановление пароля';
?>

<div class="site-login">
    <h3 class="text-center">Страница восстановления пароля</h3>
    <br>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
		<?php $form = ActiveForm::begin(); ?>
			<?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите ваш email-адрес'])->label(false) ?>

			<p class="text-center">
			<?= Html::submitButton('Submit', ['class' => 'btn btn-default']) ?>
			</p>
		<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
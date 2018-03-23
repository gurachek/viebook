<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация на Viebook';
$this->registerJs("jQuery('.layout').addClass('main-block')");
?>
<div class="site-signup">
    <h3 class="text-center">Регистрация</h3>
    <br>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['placeholder' => 'Придумайте себе никнейм', 'autofocus' => true])->label(false) ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите email-адрес'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Придумайте пароль'])->label(false) ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-danger', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

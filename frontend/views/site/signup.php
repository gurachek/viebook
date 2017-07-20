<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="site-signup">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['placeholder' => 'Придумайте себе никнейм', 'autofocus' => true])->label('') ?>

                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите email-адрес']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Придумайте пароль']) ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Зарегестрироваться', ['class' => 'btn btn-danger', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

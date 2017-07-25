<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация на Viebook';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if ($message): ?>
    <div class="alert alert-info" role="alert">
        <?= $message ?>
    </div>
<?php endif; ?>

<div class="site-login">
    <h3 class="text-center">Авторизация</h3>
    <br>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Введите свой никнейм'])->label(false) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите свой пароль'])->label(false) ?>

                <?= $form->field($model, 'rememberMe')->hiddenInput(['value' => 1])->label(false) ?>

                <p>
                    <?= Html::a('Восстановить пароль', ['site/reset-password-request']) ?>
                </p>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-danger', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

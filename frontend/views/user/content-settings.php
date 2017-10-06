<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = "Настройки";
?>

<h2 class="text-center">Настройки профиля</h2>

<?php $nicename = @Yii::$app->user->identity->nicename; ?>
<?php $about = @Yii::$app->user->identity->about; ?>

<?php Pjax::begin([
    'options' => [
        'id' => 'settings',
        'class' => 'settings',
        'data' => [
            'pjax' => true,
        ]
    ]
]); ?>

<?php $form = ActiveForm::begin(); ?>
	<?= $form->field($data, 'nicename')->textInput(['value' => $nicename])->label('Введите свое имя и фамилию'); ?>
	<?= $form->field($data, 'image')->fileInput()->label('Загрузите свое изображение'); ?>

    <?= $form->field($data, 'about')->textArea(['rows' => 6, 'cols' => 12, 'value' => $about])->label('Расскажите немного о себе'); ?>

	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-danger']); ?>
<?php ActiveForm::end(); ?>

<?php Pjax::end(); ?>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Добавить автора на сайт";
?>

<?php if (Yii::$app->session->hasFlash('success_author_add')): ?>
	<div class="alert alert-success" role="alert">
		<?= Yii::$app->session->getFlash('success_author_add'); ?>
	</div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure_author_add')): ?>
	<div class="alert alert-danger" role="alert">
		<?= Yii::$app->session->getFlash('failure_author_add'); ?>
	</div>
<?php endif; ?>

<h3>Добавление автора на сайт</h3>
<br>
<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'name')->label('Введите ФИО автора'); ?>
	<?= $form->field($model, 'image')->fileInput()->label('Загрузите изображение книги') ?>

	<?= Html::submitButton('Добавить', ['class' => 'btn btn-danger']); ?>

<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

$this->title = "Добавить книгу на сайт";

?>

<?php if (Yii::$app->session->hasFlash('success_book_add')): ?>
	<?= Yii::$app->session->getFlash('success_book_add'); ?>
<?php endif; ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $form->field($model, 'name')->label('Введите название книги') ?>
	<?= $form->field($model, 'author')->label('Выберите автора из списка')->widget(AutoComplete::classname(), [
    	'clientOptions' => [
        	'source' => $authors,
    	],
    	'options' => [
    		'class' => 'form-control',
    	]
	]) ?>
	<?= $form->field($model, 'publish_date')->label('Когда книга впервые была опубликована') ?>
	<?= $form->field($model, 'tags')->label('Начните вводить теги к этой книге') ?>
	<?= $form->field($model, 'image')->fileInput()->label('Загрузите изображение книги') ?>

	<?= Html::submitButton('Добавить', ['class' => 'btn btn-danger']); ?>

<?php ActiveForm::end(); ?>
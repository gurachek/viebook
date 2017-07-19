<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = "Добавить книгу на сайт";

?>

<?php if (Yii::$app->session->hasFlash('success_book_add')): ?>
	<div class="alert alert-success" role="alert">
		<?= Yii::$app->session->getFlash('success_book_add'); ?>
	</div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('failure_book_add')): ?>
	<div class="alert alert-danger" role="alert">
		<?= Yii::$app->session->getFlash('failure_book_add'); ?>
	</div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $form->field($model, 'name')->label('Введите название книги') ?>
	<?= $form->field($model, 'author')->label('Выберите автора из списка')->widget(AutoComplete::classname(), [
    	'clientOptions' => [
        	'source' => $authors,
            'minLength' => '3',
    	],
    	'options' => [
    		'class' => 'form-control',
    	]
	]) ?>
	<?= $form->field($model, 'publish_date')->label('Когда книга впервые была опубликована') ?>
	<?= $form->field($model, 'tags')->label('Начните вводить теги к этой книге')->widget(AutoComplete::classname(), [
    	'clientOptions' => [
        	'source' => $tags,
        	'max' => 6,
        	'highlightItem' =>  true,
        	'multiple' => true,
        	'multipleSeparator' => " ",
    	],
    	'options' => [
    		'class' => 'form-control',
    		'max' => 6,
        	'highlightItem' =>  true,
        	'multiple' => true,
        	'multipleSeparator' => " ",
    	]
	])  ?>
	<?= $form->field($model, 'image')->fileInput()->label('Загрузите изображение книги') ?>

	<?= Html::submitButton('Добавить', ['class' => 'btn btn-danger']); ?>

<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Добавить книгу на сайт";

?>

<?php if (Yii::$app->session->hasFlash('success_book_add')): ?>
	<?= Yii::$app->session->getFlash('success_book_add'); ?>
<?php endif; ?>

<h3>There u can add books</h3>

<pre>
<?php print_r($lol); ?>
</pre>

<br>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $form->field($model, 'name') ?>
	<?= $form->field($model, 'author') ?>
	<?= $form->field($model, 'publish_date') ?>
	<?= $form->field($model, 'image')->fileInput() ?>

	<?= Html::submitButton('Добавить', ['class' => 'btn btn-danger']); ?>

<?php ActiveForm::end(); ?>
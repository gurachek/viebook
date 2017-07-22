<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование рецензии на книгу "'. $book->name .'"';

?>

<?php if ($review->active): ?>
	<span style="color: green;">
		<span class="glyphicon glyphicon-exclamation-sign"></span>
		Опубликована
	</span>
<?php else: ?>
	<span style="color: orange;">
		<span class="glyphicon glyphicon-exclamation-sign"></span>
		На модерации
	</span>
<?php endif; ?>

<h3>Вы редактируете рецензию на книгу "<?= Html::a($book->name, ['book/view', 'id' => $book->id]); ?>"</h3>

<?php if (Yii::$app->session->hasFlash("success_edit_review")): ?>
	<div class="alert alert-success" role="alert">
		<?= Yii::$app->session->getFlash("success_edit_review") ?>
	</div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash("failure_edit_review")): ?>
	<div class="alert alert-warning" role="alert">
		<?= Yii::$app->session->getFlash("failure_edit_review") ?>
	</div>
<?php endif; ?>

<br>
<?php $form =  ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['value' => $review->title])->label('Заголовок'); ?>
    <?= $form->field($model, 'text')->textarea(['rows' => 20, 'value' => $review->text])->label('Текст'); ?>
    <?= $form->field($model, 'reviewid')->hiddenInput(['value' => $review->id])->label(false); ?>

    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-danger']); ?>
<?php ActiveForm::end() ?>
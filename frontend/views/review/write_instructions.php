<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Написать рецензию - Viebook';

?>

<br>

<?php if (Yii::$app->session->hasFlash("success_review_post")): ?>
	<div class="alert alert-success" role="alert">
		<?= Yii::$app->session->getFlash("success_review_post") ?>
	</div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash("failure_review_post")): ?>
	<div class="alert alert-warning" role="alert">
		<?= Yii::$app->session->getFlash("failure_review_post") ?>
	</div>
<?php endif; ?>

<br>
<?php $form =  ActiveForm::begin(); ?>
    <?= $form->field($model, 'title'); ?>
    <?= $form->field($model, 'text')->textarea(['rows' => 20]); ?>
    <?= $form->field($model, 'bookid')->hiddenInput(['value' => $book->id])->label(false); ?>
    <?= $form->field($model, 'userid')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>

    <?= Html::submitButton('Отправить', ['class' => 'btn btn-danger']); ?>
<?php ActiveForm::end() ?>
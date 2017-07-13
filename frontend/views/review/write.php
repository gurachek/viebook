<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Написание рецензии на книгу "'. $book->name .'"';

?>

<h3>Вы пишете рецензию на книгу "<?= Html::a($book->name, ['book/view', 'id' => $book->id]); ?>"</h3>
<br>
<?php if (Yii::$app->session->hasFlash("success_review_post")): ?>
	<div class="alert alert-success" role="alert">
		<?= Yii::$app->session->getFlash("success_review_post") ?>
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
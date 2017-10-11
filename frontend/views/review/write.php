<?php

use dosamigos\ckeditor\CKEditor;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Написание рецензии на книгу "'. $book->name .'"';

$js = <<<JS

CKEDITOR.config.extraPlugins = 'autogrow';
CKEDITOR.config.autoGrow_minHeight = 200;
CKEDITOR.config.autoGrow_maxHeight = 600;
CKEDITOR.config.autoGrow_bottomSpace = 50;

JS;

$this->registerJs($js);

?>

<h3>Вы пишете рецензию на книгу "<?= Html::a($book->name, ['book/view', 'id' => $book->id]); ?>"</h3>
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
    
    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'preset' => 'basic',
    ])->label(false) ?>

    <?= $form->field($model, 'bookid')->hiddenInput(['value' => $book->id])->label(false); ?>
    <?= $form->field($model, 'userid')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false); ?>

    <?= Html::submitButton('Отправить', ['class' => 'btn btn-danger']); ?>
<?php ActiveForm::end() ?>
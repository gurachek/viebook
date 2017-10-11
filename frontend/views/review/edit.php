<?php
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование рецензии на книгу "'. $book->name .'"';

$js = <<<JS

CKEDITOR.config.extraPlugins = 'autogrow';
CKEDITOR.config.autoGrow_minHeight = 200;
CKEDITOR.config.autoGrow_maxHeight = 600;
CKEDITOR.config.autoGrow_bottomSpace = 50;

JS;

$this->registerJs($js);

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
    
    <?php //$form->field($model, 'text')->textarea(['rows' => 20, 'value' => $review->text])->label('Текст'); ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['value' => $review->text],
        'preset' => 'basic',
    ]) ?>

    <?= $form->field($model, 'reviewid')->hiddenInput(['value' => $review->id])->label(false); ?>

    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-danger']); ?>
    <?= Html::a('Перейти к рецензии', ['review/view', 'id' => $review->id], ['class' => 'btn btn-link']); ?>
<?php ActiveForm::end() ?>
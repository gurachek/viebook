<?php
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование рецензии на книгу "'. $book->name .'"';

$js = <<<JS

//CKEDITOR.config.extraPlugins = 'autogrow';
//CKEDITOR.config.autoGrow_minHeight = 200;
//CKEDITOR.config.autoGrow_maxHeight = 600;
//CKEDITOR.config.autoGrow_bottomSpace = 50;

jQuery('.layout').removeClass('container');
jQuery('.layout').addClass('container-fluid');

JS;

$this->registerJs($js);

?>

<div class="row">
	<div class="col-md-9 col-sm-12 col-xs-12">
		<div class="main-block edit-review_block">

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

			<br>

			<h3 class="edit-review_mobile-book">Вы редактируете рецензию на книгу "<?= Html::a($book->name, ['book/view', 'id' => $book->id]); ?>"</h3>

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

			    <?= $form->field($model, 'preview')->textArea(['value' => $review->preview, 'rows' => '7'])->label(false); ?>

			    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
			        'options' => ['value' => $review->text],
			        'preset' => 'basic',
			    ])->label(false) ?>

			    <?= $form->field($model, 'reviewid')->hiddenInput(['value' => $review->id])->label(false); ?>

			    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-danger']); ?>
			    <?= Html::a('Перейти к рецензии', ['review/view', 'id' => $review->id], ['class' => 'btn btn-link', 'target' => '_blank']); ?>
			<?php ActiveForm::end() ?>

		</div>
	</div>
	<div class="col-md-3">
		<div class="main-block edit-review_book">
			<div class="book_page">
            <div class="name">

                <div class="image" style="text-align: center;">

                    <?= Html::a('<div style="background: url(/images/books/'. $review->book['image'] .') no-repeat; background-size: contain; width: 100%; height: 315px; background-position: center center;"></div>', ['book/view', 'id' => $review->book['id']]) ?>
                </div>

                <div style="border-top: 1px solid #e8e8e8; width: 100%; margin: 20px 0px;"></div>

                <div class="edit-review_author">
                	<span class="glyphicon glyphicon-user"></span> 
                	<?= Html::a($review->book->author['name'], ['author/view', 'id' => $review->book->author['id']]) ?>

                	<br>

                	<span class="glyphicon glyphicon-menu-hamburger"></span> 
                	<?= Html::a($review->book->cat['name'], ['category/view', 'id' => $review->book->cat['id']]) ?>

                	<br>

                	<span class="glyphicon glyphicon-scale"></span> 
                	<?= Html::a($review->book->level['name'], ['book/level', 'id' => $review->book->level['id'], 'catid' => $review->book->cat['id']]) ?>
                </div>
            
            </div>
        </div>
		</div>
	</div>
</div>
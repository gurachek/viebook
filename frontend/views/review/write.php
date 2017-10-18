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

jQuery('.container').removeClass('main-block');
jQuery('.container').addClass('container-fluid');
jQuery('.container-fluid').removeClass('container');

JS;

$this->registerJs($js);

?>

<div class="row">
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="main-block edit-review_block">

            <h3 class="edit-review_mobile-book">Вы пишете рецензию на книгу "<?= Html::a($book->name, ['book/view', 'id' => $book->id]); ?>"</h3>
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

        </div>
    </div>
    <div class="col-md-3">
        <div class="main-block edit-review_book">
            <div class="book_page">
            <div class="name">

                <div class="image" style="text-align: center;">

                    <?= Html::a('<div style="background: url(/images/books/'. $book->image .') no-repeat; background-size: contain; width: 100%; height: 315px; background-position: center center;"></div>', ['book/view', 'id' => $book->id]) ?>
                </div>

                <div style="border-top: 1px solid #e8e8e8; width: 100%; margin: 20px 0px;"></div>

                <div class="edit-review_author">
                    <span class="glyphicon glyphicon-user"></span> 
                    <?= Html::a($book->author['name'], ['author/view', 'id' => $book->author['id']]) ?>

                    <br>

                    <span class="glyphicon glyphicon-menu-hamburger"></span> 
                    <?= Html::a($book->cat['name'], ['category/view', 'id' => $book->cat['id']]) ?>

                    <br>

                    <span class="glyphicon glyphicon-scale"></span> 
                    <?= Html::a($book->level['name'], ['book/level', 'id' => $book->level['id'], 'catid' => $book->cat['id']]) ?>
                </div>
            
            </div>
            </div>
        </div>
    </div>
</div>
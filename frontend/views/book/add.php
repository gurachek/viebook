<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii2mod\selectize\Selectize;

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

<?php print_r($authors); ?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $form->field($model, 'name')->label('Введите название книги') ?>
	<?= $form->field($model, 'author')->label('Выберите автора из списка')->widget(AutoComplete::classname(), [
    	'clientOptions' => [
        	'source' => $authors,
            'minLength' => '3',
            'autoFill'=> true,
            'response' => new JsExpression('function(event, ui) {
                if (ui.content.length === 0) {
                    var inputData = jQuery("#addbookmodel-author").val();
                    jQuery(".author_image").html("Автора \"" + inputData + "\" нет на сайте, он будет добавлен на сайт автоматически.<br><br>");
                } else {

                }
            }'),
    	],
    	'options' => [
    		'class' => 'form-control',
    	]
	]) ?>

    <?= $form->field($model, 'category')->label('Категория книги')->dropDownList($categoryList, ['prompt' => 'Выберите категорию...']); ?>
    <?= $form->field($model, 'level')->label('Уровень книги')->dropDownList($bookLevelsList, ['prompt' => 'Выберите уровень...']); ?>
    <?= $form->field($model, 'pages')->label('Количество страниц')->textInput(['type' => 'number']); ?>
	<?= $form->field($model, 'publish_date')->label('Когда книга впервые была опубликована') ?>
	<?= $form->field($model, 'tags')->label('Начните вводить теги к этой книге')->widget(Selectize::className(), [
        'url' => '/book/tags',
         'pluginOptions' => [
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => ['name'],
            'persist' => false,
            'createOnBlur' => true,
            'create' => true
        ]
])  ?>
	<?= $form->field($model, 'image')->fileInput()->label('Загрузите изображение книги') ?>

    <div class="author_image"></div>

	<?= Html::submitButton('Добавить', ['class' => 'btn viebutton']); ?>

<?php ActiveForm::end(); ?>
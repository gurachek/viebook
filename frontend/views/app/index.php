<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = "Viebook - search for something here.";

?>

<?php Pjax::begin(); ?>

<?php if (!$search_results): ?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'search_form',
        'class' => 'search_input',
        'data' => [
            'pjax' => true,
        ]
    ]
]); ?>

    <h3 class="text-center">Начните вводить название книги</h3>

    <div style="width: 80%; float: left; padding-right: 5px;">
        <?= $form->field($model, 'search')->label(false)->widget(AutoComplete::classname(), [
            'clientOptions' => [
                'source' => $books,
                'minLength' => '2', // U need change it to 3
                '_renderItem' => new JsExpression('function( ul, item ) {
                    return $("<li>")
                    .append("<img src=../images/"+item.Image +" alt=\"img\" />")
                    .append("<a>" + item.value  + "<br>" + item.label  + "</a>")
                    .appendTo(ul);
                }'),
            ],
            'clientEvents' => [
                'onSelect' => "function () { alert('lol'); }"
            ],
            'options' => [
                'class' => 'form-control'
            ]
        ]) ?>
    </div>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-danger']); ?>

<?php ActiveForm::end(); ?>

<?php else: ?>

<?php

if (!is_array($search_results)) {
    echo "<h4 class='text-center'>На сайте нет такой книги</h4>";
    echo "<p class='text-center'>";
    echo Html::a('Добавить', ['book/add'], ['class' => 'btn btn-default']);
    echo "</p>";
} else { ?>

    <div class="books_searched">
    <div class="row">
    <?php foreach($search_results as $book): ?>
        <?php
        $author = $book->author['first_name'] .' '. $book->author['second_name'] .' '. $book->author['surname'];
        $category = $book->cat['name'];
        ?>

            <div class="col-md-3">
            <div class="book" style="border: 1px solid #d2d2d2;background: #F6F7F2; padding-top: 10px; margin-bottom: 10px;">
                <div class="name">
                    <?= Html::a("<h3 style='margin: 0;'>$book->name</h3>", ['book/view', 'id' => $book->id]); ?>
                </div>
                <div class="image" style="background: url(images/books/<?= $book->image ?>); background-size: cover;">

                </div>
                <div class="publish_date">
                    <span class="publish_label">Дата публикации: </span>
                    <?= $book->publish_date ?>
                </div>
                <div class="author">
                    <span class="author_label">Автор: </span>
                    <?= $author ?>
                </div>
                <div class="category">
                    <span class="category_label">Категория: </span>
                    <?= $category ?>
                </div>
            </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
<?php } ?>

<?php endif; ?>

<?php Pjax::end(); ?>

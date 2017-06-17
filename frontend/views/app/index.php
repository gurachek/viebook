<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = "Search something you interesting in";

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

    <h3>Введите название книги</h3>

    <?= $form->field($model, 'search')->label(false) ?>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>

<?php else: ?>

<?php

if (!is_array($search_results)) {
    echo "<h3>$search_results</h3>";
} else { ?>

    <div class="books_searched">

    <?php foreach($search_results as $book): ?>
        <?php
        $author = $book->author['first_name'] .' '. $book->author['second_name'] .' '. $book->author['surname'];
        $category = $book->cat['name'];
        ?>

            <div class="book">
                <div class="name">
                    <h3 style="margin: 0;"><?= $book->name ?></h3>
                </div>
                <div class="image" style="background: url(images/books/<?= $book->image ?>); background-size: cover;">
                    <div class="read_reviews">
                        <?= Html::a('Читать рецензии', ['book/view', 'id' => $book->id], ['class' => 'read_reviews_button']) ?>
                    </div>
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
        <?php endforeach; ?>
    </div>
<?php } ?>

<?php endif; ?>

<?php Pjax::end(); ?>

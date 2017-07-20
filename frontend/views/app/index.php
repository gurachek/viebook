<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = "Viebook - search for something here.";

$js = <<<JS


jQuery(document).ready(function () {
    jQuery('.loader').css('display', 'none');
    jQuery('.search_submit').on('click', function () {
        if (jQuery('#searchmodel-search').val() != '') {
            jQuery('#search_form').fadeTo(1000, 0.3);
            jQuery('.loader').css('display', 'block');
        }
    });
});

JS;

$this->registerJs($js);

?>

<?php Pjax::begin(); ?>

<?php if (!$search_results): ?>

<div class="loader" style="display: none; position: absolute; top: 20%; left: 40%; background: url(images/loader.gif) no-repeat; width: 200px; height: 100px;">
    
</div>

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
                'minLength' => '3',
            ],
            'clientEvents' => [

            ],
            'options' => [
                'class' => 'form-control'
            ]
        ]) ?>
    </div>

    <?= Html::submitButton('Submit', ['class' => 'btn btn-danger search_submit']); ?>

<?php ActiveForm::end(); ?>

<br>

<?php if ($dailyBooks): ?>
<div class="text-center">
<br>

<ul class="list-inline">
    <li><?= Html::a("Список книг", ['book/list']) ?></li>
    <li><?= Html::a("Список авторов", ['author/list']) ?></li>
    <li><?= Html::a("Список пользователей", ['user/list']) ?></li>
</ul>
</div>

<?php foreach($dailyBooks as $book): ?>
    <?php 
        if (!$book['reviews']) {
            continue;
        }
    ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <div class="col-md-9 daily_book col-md-offset-1" style="padding-left: 15px;">
                <?= Html::a('
                <div class="daily_image" style="background: url(images/books/'.$book['image'].') no-repeat center; background-size: contain;"></div>
                ', ['book/view', 'id' => $book['id']]) ?>
                <p>
                <h4 class="text-center"><?= $book['name']; ?></h4>
                    <?php foreach ($book['reviews'] as $review) : ?>
                        <p style="color: gray;">Рейтинг: <?= $review->rating ?></p>
                        <?php $text = intval(strlen($review->text) / 4) ?>
                        <?= mb_substr($review->text, 0, $text, "utf-8") ?>...
                        <?= Html::a('Читать', ['review/view', 'id' => $review->id]) ?>
                        <br>
                        
                        <?php if ($book->tags): ?>
                            <br>
                            
                            <p style="display:table-cell;vertical-align:bottom;">
                            Теги: 
                            
                            <?php foreach($book->tags as $tag): ?>
                                <?php foreach($tag->name as $name): ?>
                                    <?= Html::a($name['name'], ['search/tag', 'id' => $name->id]) ?>,                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            </p>

                        <?php endif; ?>
                        
                        <?php break; ?>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>

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
        <?php $category = $book->cat['name']; ?>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="book" style="border: 1px solid #d2d2d2;background: #F6F7F2; padding-top: 10px; margin-bottom: 10px;">
                <div class="name">
                    <?= Html::a("<h4 style='margin: 0;'>$book->name</h4>", ['book/view', 'id' => $book->id]); ?>
                </div>
                <div class="image" style="background: url(images/books/<?= $book->image ?>); background-size: cover;">

                </div>
                <div class="publish_date">
                    <span class="publish_label">Дата публикации: </span>
                    <?= $book->publish_date ?>
                </div>
                <div class="author">
                    <span class="author_label">Автор: </span>
                    <?= $book->author['name'] ?>
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

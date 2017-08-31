<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = "Viebook - выберите книгу, которая подойдет вам, как специалисту";

$js = <<<JS


jQuery(document).ready(function () {
    jQuery('.loader').css('display', 'none');
    jQuery('.viebutton').on('click', function () {
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
<br>
<div class="loader" style="display: none; position: absolute; top: 15%; left: 44%; background: url(images/loader.gif) no-repeat; width: 200px; height: 100px; z-index: 9999;">
    
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?php $form = ActiveForm::begin([
            'options' => [
                'id' => 'search_form',
                'class' => 'search_input',
                'data' => [
                    'pjax' => true,
                ]
            ]
        ]); ?>

        <div style="width: 80%; float: left; padding-right: 5px;">
            <?= $form->field($model, 'search')->label(false)->widget(AutoComplete::classname(), [
                'clientOptions' => [
                    'source' => $books,
                    'minLength' => '3',
                ],
                'clientEvents' => [

                ],
                'options' => [
                    'class' => 'form-control',
                ]
            ])->textInput(['placeholder' => 'Начните вводить название книги...']) ?>
        </div>

        <?= Html::submitButton('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>', ['class' => 'btn viebutton']); ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<br>

<?php if ($dailyBooks): ?>

<div id="columns">

<?php foreach($dailyBooks as $book): ?>
    <?php 
        if (!$book['reviews']) {
            continue;
        }

        $review = $book['reviews'][0];
    ?>

    <div class="pin">
        <?= Html::a('
            <div class="daily_image" style="background: url(images/books/'.$book['image'].') no-repeat center; background-size: contain;"></div>
            ', ['book/view', 'id' => $book['id']]) ?>
        
        <h4 class="text-center"><?= $book['name']; ?></h4>

        <?php
            $positive = !empty($review->estimates) ? @$review->estimates[0]->numberOfPositive() : 0;
            $negative = !empty($review->estimates) ? @$review->estimates[0]->numberOfNegative() : 0;
        ?>

        <div class="estimate" style="font-size: 15px; margin-bottom: 10px;">
            <span class="like-count" style="font-size: 15px;">
                <?= $positive ?>
            </span>
            <span title="Понравилось" class="glyphicon glyphicon-heart-empty like" data-id="1"></span>
            <span class="dislike-count" style="font-size: 15px;">
                <?= $negative ?>
            </span>
            <span title="Не понравилось" class="glyphicon glyphicon-send dislike" data-id="0"></span>
        </div>

        <p>
            <?php $text = intval(strlen($review->text) / 8) ?>
                    <?= mb_substr($review->text, 0, $text, "utf-8") ?>...
                    <?= Html::a('Читать', ['review/view', 'id' => $review->id]) ?>
                    <br>
        </p>

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
    </div>

<?php endforeach; ?>
</div>
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
    <h3 class="text-center">Все, что найдено по запросу "<?= $search_query ?>"</h3>
    <br>
    <div class="row">
    <?php foreach($search_results as $book): ?>
        <?php $category = $book->cat['name']; ?>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="daily_book" style="padding: 10px;">
                <div class="name">
                    <?= Html::a('<div class="image" style="background: url(images/books/'.$book->image.'); background-size: cover;"></div>', ['review/view', 'id' => $book->reviews[0]['id']]); ?>
                </div>

                <div style="width: 200px; margin: 0 auto;">
                    <div class="publish_date">
                        <!-- <span class="publish_label">Дата публикации: </span> -->
                        <span class="glyphicon glyphicon-calendar"></span>
                        <?= $book->publish_date ?>
                    </div>
                    <div class="author">
                        <!-- <span class="author_label">Автор: </span> -->
                        <span class="glyphicon glyphicon-user"></span>
                        <?= $book->author['name'] ?>
                    </div>
                    <div class="category">
                        <!-- <span class="category_label">Категория: </span> -->
                        <span class="glyphicon glyphicon-book"></span>
                        <?= $category ?>
                    </div>
                </div>
            </div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>
<?php } ?>

<?php endif; ?>

<?php Pjax::end(); ?>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$this->title = "Viebook. Поменьше бы вашего бла-бла-бла";

$js = <<<JS


jQuery(document).ready(function () {
    jQuery('.loader').css('display', 'none');
    jQuery('.viebutton').on('click', function () {
        if (jQuery('#searchmodel-search').val() != '') {
            jQuery('#search_form').fadeTo(1500, 0.3);
            // jQuery('.loader').css('display', 'block');
        }
    });

    jQuery('.pin .daily_image').hover(function () {
        jQuery(this).css('background-size', 'contain');
    });
    
    jQuery('.pin .daily_image').mouseout(function () {
        jQuery(this).css('background-size', 'cover');
    });

    jQuery('.layout').removeClass('container');
    jQuery('.layout').addClass('container-fluid');

    jQuery('.free-space').css('margin-top', '-10px');
});

JS;

$this->registerJs($js);

?>

<?php Pjax::begin(); ?>

<?php if (!$search_results): ?>
<br>

<div class="row search-input-block2" style="display: none;">
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

<h3 style="margin-top: 0; color: #444">Вам может понравиться</h3>
<div class="orange-line"></div>

<?php if ($weeklyReviews): ?>

<div id="columns">

<?php foreach($weeklyReviews as $review): ?>

    <div class="pin shadow">
        <?= Html::a('
            <div class="daily_image" style="background: url(images/books/'.$review->book['image'].') no-repeat center; background-size: cover"></div>
            ', ['book/view', 'id' => $review->book['id']]) ?>
        
        <div style="padding: 15px; padding-bottom: 0">

        <h4 class="text-center"><?= $review->book['name']; ?></h4>

        <?php
            $positive = !empty($review->estimates) ? @$review->estimates[0]->numberOfPositive() : 0;
        ?>

        <div class="estimate" style="font-size: 15px; margin-bottom: 10px;">
            <span class="like-count" style="font-size: 15px;">
                <?= $positive ?>
            </span>
            <span title="Понравилось" class="glyphicon glyphicon-heart-empty like" data-id="1"></span>
            <span class="dislike-count" style="font-size: 15px;">
                <?= $review->views ?>
            </span>
            <span title="Просмотров" class="glyphicon glyphicon-eye-open dislike" data-id="0"></span>
        </div>

        <p>
            <?= $review->preview ?>
            <?= Html::a('Читать', ['review/view', 'id' => $review->id]) ?>
        </p>

        </div>

        <?php if ($review->book->tags): ?>

            <div class="tags">
            
            <?php foreach($review->book->tags as $tag): ?>
                <?php foreach($tag->name as $name): ?>
                    <?= Html::a($name['name'], ['search/tag', 'id' => $name->id], ['class' => 'book-block-tag']) ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </div>

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
    <h3 class="text-center"><?= $search_query ?></h3>
    <br>
    <div class="row">
    <?php foreach($search_results as $book): ?>
        <?php $category = $book->cat['name']; ?>
        <?php $categoryId = $book->cat['id']; ?>

            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="daily_book" style="padding: 10px;">
                <div class="name">
                    <div class="author">
                            <?= Html::a($book->author['name'], ['author/view', 'id' => $book->author['id']]) ?>
                    </div>

                    <?php if (@$book->reviews[0]): ?>

                        <?= Html::a('<div class="image" style="background: url(/images/books/'.$book->image.') no-repeat; background-size: cover;" title="'. $book->name .'"></div>', ['review/view', 'id' => @$book->reviews[0]['id']]); ?>
                
                    <?php else: ?>

                        <?= Html::a('<div class="image" style="background: url(/images/books/'.$book->image.') no-repeat; background-size: contain;" title="'. $book->name .'"></div>', ['book/view', 'id' => $book->id]); ?>

                    <?php endif; ?>
                </div>

                <div style="width: 100%; margin: 0 auto;">
                    <div class="publish_date">
                        <span class="glyphicon glyphicon-calendar"></span>
                        <?= $book->publish_date ?>
                    </div>
                    <div class="category">
                        <span class="glyphicon glyphicon-menu-hamburger"></span>
                        <?= Html::a($category, ['category/index', 'id' => $categoryId]) ?>
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

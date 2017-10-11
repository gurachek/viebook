<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $review->title .' - "'. $review->book->name .'" '. $review->book->author->name ;

// For estimate
$url = Yii::$app->getUrlManager()->createAbsoluteUrl(['review/estimate']);
$bookVisitUrl = Yii::$app->getUrlManager()->createAbsoluteUrl(['book/visit']);
$reviewViewUrl = Yii::$app->getUrlManager()->createAbsoluteUrl(['review/ajax-view']);
$userId = Yii::$app->user->getId() ?? 0;
$reviewId = $review->id;

$customJs = <<< JS

jQuery.ajax({
    url: "$reviewViewUrl",
    method: "GET",
    data: {
        reviewId: {$review->id},
    },
    success: function (data) {

    },
});

jQuery.ajax({
    url: "$bookVisitUrl",
    method: "GET",
    data: {
        bookId: {$review->book->id},
    },
    success: function (data) {

    },
});

jQuery(document).ready(function () {
    jQuery('.estimate .like').css('cursor', 'pointer');
    jQuery('.estimate .dislike').css('cursor', 'pointer');
    jQuery('.estimate span').click(function () {
        var id = parseInt(jQuery(this).data('id'));

        var estimate_number = '.dislike-count';

        if (id == 1) {
            estimate_number = '.like-count';
        }

        jQuery('.estimate').addClass('estimate_opacity');
        jQuery(this).addClass('estimate_rotate');

        jQuery.ajax({
            url: "$url",
            method: "POST",
            data: {
                userId: $userId,
                reviewId: $reviewId,
                estimate: id,
            },
            success: function (data) {
                if (!data) {
                    jQuery('.ty_for_estimate').css('background', 'rgba(0, 0, 0, 0.9)');
                    jQuery('.ty_for_estimate .text').html('<span class="glyphicon glyphicon-remove-sign"> </span>&nbsp;&nbsp;Вы уже оценивали эту рецензию');
                
                    jQuery('.estimate').css('display', 'none');
                } else {

                    var number = parseInt(jQuery(estimate_number).html());
                    number += 1;
                    jQuery(estimate_number).html(number + ' ');

                    jQuery('.estimate').css('display', 'none');
                }

                jQuery('.ty_for_estimate').css('display', 'block');
                jQuery('.estimate').removeClass('estimate_opacity');
                jQuery('.estimate span').removeClass('estimate_rotate');

                // jQuery('.ty_for_estimate').fadeOut(3000);
                jQuery('.ty_for_estimate').animate({'opacity':'0.4'}, 3000, function () {
                    jQuery('.ty_for_estimate').css('display', 'none');
                    jQuery('.estimate').css('display', 'block');
                });
            },
        });
    });
});

JS;

if (Yii::$app->user->getId()) $this->registerJs($customJs);

?>

<div class="row review_page">
    <div class="col-md-8">

        <ul class="list-inline" style="color: gray;">
            <li class="display_on_mobile_book_block">
                <span class="glyphicon glyphicon-book"></span>
                <?= Html::a($review->book['name'], ['book/view', 'id' => $review->book['id']]) ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-user"  title="Автор рецензии"></span>
                <?= Html::a($review->author->getName(), ['user/view', 'id' => $review->author->id]) ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-menu-hamburger" title="Категория"></span>
                <?= Html::a($review->book->cat['name'], ['category/index', 'id' => $review->book->cat['id']]) ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-calendar"  title="Дата написания"></span>
                <?= date("d M Y", $review->created_at) ?>
            </li>
            <li>
                <span class="glyphicon glyphicon-eye-open"  title="Просмотры"></span>
                <?= $review->views ?>
            </li>
        </ul>

        <h3><?= $review->title ?>
            <?php if (Yii::$app->user->getId() == $review->author['id']): ?>
            <?= Html::a('
            <small title="Редактировать" style="color: gray;">
                <span class="glyphicon glyphicon-edit"></span>
            </small>', ['review/edit', 'id' => $review->book['id']]) ?>
            <?php endif; ?>
        </h3>
        <br>
        
        <div style="font-size: 17px; line-height: 1.6em;">
            <?= nl2br($review->text) ?>
        </div>

        <div class="ty_for_estimate text-center" role="alert">
            <span class="text">
                <span class="glyphicon glyphicon-ok-sign"></span>
                &nbsp;&nbsp;
                Спасибо за оценку
            </span>
        </div>

        <?php //if ($id = Yii::$app->user->getId()): ?>

            <?php if (@$review->user_id != @$id): ?>
            
                <?php
                    $positive = !empty($review->estimates) ? @$review->estimates[0]->numberOfPositive() : 0;
                    $negative = !empty($review->estimates) ? @$review->estimates[0]->numberOfNegative() : 0;
                ?>

                <div class="estimate" style="text-align: center;">
                    <span class="like-count">
                        <?= $positive ?>
                    </span>
                    <span title="Понравилось" class="glyphicon glyphicon-heart-empty like" data-id="1"></span>
                    
                    <span class="dislike-count">
                        <?= $negative ?>
                    </span>
                    <span title="Не понравилось" class="glyphicon glyphicon-off dislike" data-id="0"></span>
                </div>

            <?php else: ?>
                <p class="text-center">
                <span style="color: gray;">
                    <?php if(!empty($review->estimates)): ?>
                        Положительных оценок: <?= $review->estimates[0]->numberOfPositive() ?>
                        <br>
                        Отрицательных оценок: <?= $review->estimates[0]->numberOfNegative() ?>
                    <?php else: ?>
                        У этой рецензии нет оценок
                    <?php endif; ?>
                </span>
                </p>
            <?php endif; ?>
            
        <?php ///else: ?>

            <br>
            <div class="signup-for-estimate text-center">
                <?= Html::a('Войдите, чтобы оценить рецензию', ['site/login', 'a' => 'review_view', 'id' => $review->id], ['class' => 'btn btn-success']); ?>
            </div>

        <?php //endif; ?>

        <?php if (@$review->user_id != @$id) { ?>
        <p>
            Думаете, что можете лучше?
            <?= Html::a("Напишите", ['review/write', 'bookid' => $review->book['id']], ['class' => '']); ?>
            свой обзор на данную книгу.
        </p>
        <?php } ?>

    </div>
    <div class="col-md-4 review_display_book_block">
        <div class="book_page">
            <div class="name">
                <!-- <h3 style="margin: 0; text-align: center;"><?= $review->book['name'] ?></h3> -->
            </div>
            <div class="image" style="text-align: center;">
                <div style="background: url(/images/books/<?= $review->book['image'] ?>) no-repeat; background-size: contain; width: 100%; height: 315px; background-position: center center; margin-top: 10px;"></div>
                <?= Html::a("Другие рецензии к этой книге", ['book/view', 'id' => $review->book['id']], ['class' => 'btn btn-lnk']); ?>
            </div>
        </div>
    </div>
</div>

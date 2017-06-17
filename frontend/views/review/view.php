<?php
use yii\helpers\Url;

$this->title = 'Viebook: '. $review->title;

// For estimate
$url = "http://localhost/".Url::to(['review/estimate']);
$userId = Yii::$app->user->getId();
$reviewId = $review->id;

$estimateReview = <<< JS

jQuery(document).ready(function () {
    jQuery('.estimate span').click(function () {
        var id = jQuery(this).data('id');

        jQuery.ajax({
            url: "$url",
            method: "POST",
            data: {
                userId: $userId,
                reviewId: $reviewId,
                estimate: id,
            },
            success: function (data) {
                if (!data)
                    jQuery('.ty_for_estimate .text').html('<span class="glyphicon glyphicon-warning-sign"></span> Вы уже оценивали эту рецензию');
                jQuery('.ty_for_estimate').css('display', 'block');
            },
        });
    });
});

JS;

$this->registerJs($estimateReview);

?>

<div class="row review_page">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <h3 class="text-center"><?= $review->title ?></h3>
        <br>
        <p>
            Рейтинг: <?= $review->rating ?>
        </p>
        <p>
            <?= $review->text ?>
        </p>

        <div class="alert alert-success alert-dismissible fade in text-center ty_for_estimate" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <span class="text">
                <span class="glyphicon glyphicon-ok"></span>
                Спасибо за оценку
            </span>
        </div>

        <div class="estimate" style="text-align: center;">
            <span title="Понравилось" class="glyphicon glyphicon-thumbs-up like" data-id="1"></span>
            <span title="Не понравилось" class="glyphicon glyphicon-thumbs-down dislike" data-id="0"></span>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

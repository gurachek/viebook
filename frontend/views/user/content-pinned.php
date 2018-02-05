<?php
use yii\helpers\Html;

$this->title = "Pinned reviews | Viebook";

$review = $data[0];

$js = <<<JS

jQuery(document).ready(function () {
	jQuery('.pinned_reviews').parent().removeClass('main-block');
	jQuery('.pinned_reviews').parent().css('padding-top', '0')
});

JS;

$this->registerJs($js);

?>

<div class="pinned_reviews">

<?php foreach($data as $review): ?>

    <div class="pinned">
        <div class="book" style="
        float: left;
        width: 200px;
        background: url(/images/books/<?= $review->book->image ?>) no-repeat;
        background-position: center center;
        height: 200px;
        margin-right: 15px;
        background-size: contain;
        margin-top: 10px;
        padding-bottom: 10px;
        cursor: pointer;
        "></div>

        <div class="right-block">

            <div class="review-title">
                <h3>
                    <?= Html::a($review->title, ['review/view', 'id' => $review->id], ['style' => 'color: #444']) ?>
                </h3>
            </div>


            <div class="book-name">
                <span class="glyphicon glyphicon-book"></span>
                <?= Html::a($review->book->name, ['book/view', 'id' => $review->book->id], ['style' => 'color: gray;']); ?>
            </div>

            <div class="pull-left">
                
                <?php

                    $likes = @$review->estimates[0] ? @$review->estimates[0]->numberOfPositive() : 0; 

                ?>

                <span class="glyphicon glyphicon-heart-empty"></span>
                <span class="likes"><?= $likes ?></span>

                &nbsp;

                <span class="glyphicon glyphicon-eye-open"></span>
                <span class="views"><?= $review->views ?></span>
            
            </div>
            
            <div class="pull-right">
                <span style="color: gray;margin-right: 15px;"><?= date('d M Y', $review->created_at) ?></span>
            </div>

            <div style="width: 100%;height: 20px;padding: 15px;"></div>
            
            <div class="preview">
                <p style="color: #444;"><?= $review->preview ?></p>
            </div>

        </div>
    </div>

<?php endforeach; ?>

</div>
<?php
use yii\helpers\Html;

$url = Yii::$app->getUrlManager()->createAbsoluteUrl(['god/publish']);

$js = <<<JS

    jQuery('.publish').click(function () {
       var id = jQuery(this).data('id');
       
       
       
       jQuery.ajax({
            url: "$url",
            method: "POST",
            data: {
                review_id: id,
            },
            success: function (data) {
                console.log(data);
                jQuery('.review-' + id).fadeOut(1000);
            },
        });
    });

JS;

$this->registerJs($js);

?>
    <h2 class="text-center">Новые рецензии</h2>

<?php if (!$reviews): ?>
    <p class="text-center">
        Нет новых рецензий.
    </p>
<?php endif; ?>
    <br>
<?php foreach($reviews as $review): ?>
    <div class="review-<?= $review['id'] ?>">
    <h4>
        <?= Html::a($review['title'], ['review/view', 'id' => $review['id']]) ?>
        <small>
            <span class="glyphicon glyphicon-menu-right"></span>
            <?= $review['book']['name'] ?>
        </small>
    </h4>

    <p>
        <?php $text = intval(strlen($review['text']) / 5) ?>
        <?= mb_substr($review['text'], 0, $text, "utf-8") ?>...
    <p class="text-right">
        <?= Html::button('Опубликовать', ['class' => 'btn btn-warning publish', 'data-id' => $review['id']]) ?>

    </p>
    </p>
    <br>
    </div>
<?php endforeach; ?>
<?php
use yii\helpers\Html;

$this->title = '"'. $book->name .'" '. $book->author['name'];

$url = Yii::$app->getUrlManager()->createAbsoluteUrl(['review/ajax']);
$bookVisitUrl = Yii::$app->getUrlManager()->createAbsoluteUrl(['book/visit']);

$customJs = <<<JS

jQuery.ajax({
    url: "$bookVisitUrl",
    method: "GET",
    data: {
        bookId: {$book->id},
    },
    success: function (data) {

    },
});

jQuery('.review_text').click(function() {
    $('.review_modal').modal('show');
    var id = jQuery(this).data('id');
    $.ajax({
       url: "$url",
       type: 'GET',
       data: {
           review_id: id,
       },
       success: function (data) {
          var review = JSON.parse(data);
          var reviewText = nl2br(review.text);
          $('.modal-content #review_content').html('<h3 class="text-center">' + review.title + '</h3><br><span style="font-size: 16px; color: #444;">' + reviewText + '</span><br><br>');

       }
  });
});

JS;

$this->registerJs($customJs);

?>

<script>
function nl2br(str) {
   return str.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '<br>');
}
</script>

<div class="modal fade review_modal" tabindex="-1" role="dialog" aria-labelledby="read_this_review">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 10px 30px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div id="review_content"><center><img src="/images/loader.gif"></center></div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-4 col-md-push-8">
        <div class="book_page">
            <div class="name">
                <h3 style="margin: 0; text-align: center;"><?= $book->name ?></h3>
            </div>
            <div class="image" style="text-align: center;">
                <div style="background: url(/images/books/<?= $book->image ?>) no-repeat; background-size: contain; width: 100%; height: 315px; background-position: center center; margin-top: 10px;"></div>
                <br>
                <br>
                <?= Html::a("Написать рецензию", ['review/write', 'bookid' => $book->id], ['class' => 'btn btn-default']); ?>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-md-pull-4">
        <h3 class="text-center">Рецензии</h3>
        <br>
        <?php if ($book->reviews): ?>
            <div class="book_reviews">
                <?php foreach($book->reviews as $review): ?>
                    <div class="single_review">
                        <div class="status_line">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <?= Html::a($review->author->getName(), ['user/view', 'id' => $review->author['id']]) ?>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <span class="glyphicon glyphicon-eye-open"></span>
                            <?= $review->views ?>

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <span class="glyphicon glyphicon-calendar"></span>
                            <?= date("d M Y", $review->created_at) ?>
                        </div>
                        <div class="review_text" data-id="<?= $review->id ?>">
                            <?= mb_substr(strip_tags($review->text), 0, 1000, "utf-8") ?>...
                        </div>
                        <br>
                        <div class="go_read">
                            <?= Html::a("Читать дальше", ['review/view', 'id' => $review->id], ['class' => 'btn viebutton pull-right read_this_review']); ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>

            <div class="text-center">
                Нет рецензий к этой книге. Но вы можете написать ее сами.
            </div>

        <?php endif; ?>
    </div>
</div>

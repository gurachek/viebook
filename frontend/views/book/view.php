<?php
use yii\helpers\Html;

$this->title = '"'. $book->name .'" '. $book->author['name'];

$url = Yii::$app->request->baseUrl;

$readReviewButton = <<<JS

jQuery('.review_text').click(function() {
    var id = jQuery(this).data('id');
    $.ajax({
       url: "$url?r=review/ajax&id=$book->id",
       type: 'GET',
       data: {
           review_id: id,
       },
       success: function (data) {
          var review = JSON.parse(data);
          $('.review_modal').modal('show');
          $('.modal-content #review_content').html('<h3 class="text-center">' + review.title + '</h3><span style="font-size: 16px;">' + review.text + '</span><br><br>');

       }
  });
});

JS;

$this->registerJs($readReviewButton);

?>

<div class="modal fade review_modal" tabindex="-1" role="dialog" aria-labelledby="read_this_review">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 10px 30px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div id="review_content"><center><img src="images/loader.gif"></center></div>
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
                <img src="/images/books/<?= $book->image ?>" width="200" height="315">
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
                            <?php $text = intval(strlen($review->text) / 3) ?>
                            <?= mb_substr($review->text, 0, $text, "utf-8") ?>...
                        </div>
                        <br>
                        <div class="go_read">
                            <?= Html::a("Читать дальше", ['review/view', 'id' => $review->id], ['class' => 'btn btn-danger pull-right read_this_review']); ?>

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

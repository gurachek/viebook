<?php 
use yii\helpers\Html;

$this->title = 'Книги из категории "'. $books[0]->cat['name'] .'"';

$js = <<<JS

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

JS;

$this->registerJs($js);

?>

<?php if ($books): ?>

	<div class="text-center">
        <h3>
            <?= $books[0]->cat['name'] ?>
            <?php if (Yii::$app->user->getId()): ?>
        
            <a class="btn btn-default follow_topic">
                    Подписаться <span style="font-weight: bold; color: #66A6D2;">+</span>
            </a>

        <?php endif; ?>
        </h3>

    </div>

	<br>

	<?= $this->render('/parts/_book', ['books' => $books]); ?>

	<?php else: ?>

	<h4>На сайте нет подходящих книг</h4>

<?php endif; ?>

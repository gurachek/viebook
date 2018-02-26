<?php
use yii\helpers\Html;

$tag_name = mb_strtoupper(mb_substr($tag->name, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($tag->name, 1, null,'UTF-8');

$this->title = 'Тема "'. $tag_name .'" на Viebook';

?>


<div class="text-center">
        <h1>
            <?= $tag_name ?>
        
            <a class="btn btn-default follow_topic">Подписаться <span class="glyphicon glyphicon-plus"></span></a>

           <!--  <a class="btn btn-default unfollow_topic">Вы подписаны <span class="glyphicon glyphicon-ok"></span></a> -->

        </h1>

    </div>
<br>

<?php if ($books): ?>

	<?= $this->render('/parts/_book', ['books' => $books]); ?>

	<?php else: ?>

	<h4>На сайте нет подходящих книг</h4>

<?php endif; ?>

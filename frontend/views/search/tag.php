<?php
use yii\helpers\Html;

$this->title = 'Поиск по теме "'. $tag->name .'"';
?>

<h1>Поиск книг по теме "<?= $tag->name ?>"</h1>
<br>

<?php if ($books): ?>

	<div class="books_searched">
	<div class="row">
	    <?php foreach($books as $book): ?>
	        <?php $category = $book->cat['name']; ?>

	    	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
	    	<div class="book" style="border: 1px solid #d2d2d2;background: #F6F7F2; padding-top: 10px; margin-bottom: 10px;">
	            <div class="name">
	                <?= Html::a("<h4 style='margin: 0;'>$book->name</h4>", ['book/view', 'id' => $book->id]); ?>
	            </div>
	            <div class="image" style="background: url(/images/books/<?= $book->image ?>); background-size: cover;">

	            </div>
	            <div class="publish_date">
	                <span class="publish_label">Дата публикации: </span>
	                <?= $book->publish_date ?>
	            </div>
	            <div class="author">
	                <span class="author_label">Автор: </span>
	                <?= $book->author['name'] ?>
	            </div>
	            <div class="category">
	                <span class="category_label">Категория: </span>
	                <?= $category ?>
	            </div>
	    	</div>
	    	</div>
	    <?php endforeach; ?>
	</div>
	</div>

	<?php else: ?>

	<h4>На сайте нет подходящих книг</h4>

<?php endif; ?>

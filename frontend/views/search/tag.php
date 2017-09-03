<?php
use yii\helpers\Html;

$this->title = 'Книги по теме "'. $tag->name .'" на Viebook';
?>

<h3 class="text-center">Книги по теме "<?= $tag->name ?>"</h3>
<br>

<?php if ($books): ?>

	<div class="books_searched">
	<div class="row">
	    <?php foreach($books as $book): ?>
	        <?php $category = $book->cat['name']; ?>
	        <?php $categoryId = $book->cat['id']; ?>

	    	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
	    	<div class="daily_book" style="padding: 10px;">
                <div class="name">
                    <div class="author">
                            <?= Html::a($book->author['name'], ['author/view', 'id' => $book->author['id']]) ?>
                    </div>

                    <?php if (@$book->reviews[0]): ?>

                    	<?= Html::a('<div class="image" style="background: url(/images/books/'.$book->image.') no-repeat; background-size: contain;" title="'. $book->name .'"></div>', ['review/view', 'id' => @$book->reviews[0]['id']]); ?>
                
	                <?php else: ?>

	                	<?= Html::a('<div class="image" style="background: url(/images/books/'.$book->image.') no-repeat; background-size: contain;" title="'. $book->name .'"></div>', ['book/view', 'id' => $book->id]); ?>

	                <?php endif; ?>
                </div>

                <div style="width: 100%; margin: 0 auto;">
                    <div class="publish_date">
                        <!-- <span class="publish_label">Дата публикации: </span> -->
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

	<?php else: ?>

	<h4>На сайте нет подходящих книг</h4>

<?php endif; ?>

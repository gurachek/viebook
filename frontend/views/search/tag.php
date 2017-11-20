<?php
use yii\helpers\Html;

$tag_name = mb_strtoupper(mb_substr($tag->name, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($tag->name, 1, null,'UTF-8');

$this->title = 'Тема "'. $tag_name .'" на Viebook';

?>


<div class="text-center">
        <h3>
            <?= $tag_name ?>
            <?php if (Yii::$app->user->getId()): ?>
        
            <a class="btn btn-default follow_topic">
                    Подписаться <span style="font-weight: bold; color: #66A6D2;">+</span>
            </a>

        <?php endif; ?>
        </h3>

    </div>
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

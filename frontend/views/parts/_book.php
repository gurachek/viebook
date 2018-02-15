<?php 
use yii\helpers\Html;
?>

<div class="row">
    <?php foreach($books as $book): ?>
        <?php $category = $book->cat['name']; ?>
        <?php $categoryId = $book->cat['id']; ?>

        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 book-list-col">
                
                <div class="book-list">
                    
                    <?= Html::a("
                    <div title='{$book->name}' class='image' style='
                        background: url(/images/books/{$book->image}) no-repeat;
                        background-position: center center;
                        background-size: cover;
                    '></div>", ['book/view', 'id' => $book->id]);
                    ?>
                    <div class="short-info text-center">
                        
                        <span class="glyphicon glyphicon-tags"></span>
                        <?= Html::a($book->cat['name'], ['category/index', 'id' => $book->cat['id']], ['class' => 'dark-link']) ?>
                        &nbsp;&nbsp;
                        <span class="glyphicon glyphicon-scale"></span>
                        <?= Html::a($book->level['name'], ['level', 'id' => $book->level['id'], 'catid' => $book->cat['id']], ['class' => 'dark-link']) ?>
                        &nbsp;&nbsp;&nbsp;
                        <!-- <span class="glyphicon glyphicon-pencil"></span> -->
                        <?php count($book->reviews) ?>
                    </div>
                    <div class="title"><h3 class="text-center"><?= $book->name ?></h3></div>
                    <div class="view">
                        <?php if (@$book->reviews[0]): ?>
                            <span class="glyphicon glyphicon-link"></span>
                            <?= Html::a('Открыть лучший обзор', ['review/view', 'id' => $book->reviews[0]['id']]); ?>
                        <?php else: ?>
                            Пока нет обзоров на эту книгу.
                        <?php endif; ?>
                    </div>
                </div>

            </div>

    	<!-- <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    	<div class="books_searched" style="padding: 10px;">
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
                    <span class="glyphicon glyphicon-calendar"></span>
                    <?= $book->publish_date ?>
                </div>
                <div class="category" style="display: none;">
                    <span class="glyphicon glyphicon-menu-hamburger"></span>
                    <?= Html::a($category, ['category/index', 'id' => $categoryId]) ?>
                </div>
                <div class="level" style="display: none;">
                    <span class="glyphicon glyphicon-scale"></span> 
                    <?= Html::a($book->level['name'], ['book/level', 'id' => $book->level['id'], 'catid' => $categoryId]) ?>
                </div>
            </div>
        </div>
    	</div> -->
    <?php endforeach; ?>
</div>
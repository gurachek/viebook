<?php
use yii\helpers\Html;

$this->title = $author->name . " - Viebook";

$js = <<<JS

jQuery('.container').removeClass('main-block');

JS;

$this->registerJs($js);

?>

<div class="row">
	<div class="col-md-4">
		<div class="main-block">
			<div title='<?= $author->name ?>' style='background: url(/images/authors/<?= $author->image ?>) no-repeat center; background-size: contain; width: 100%; height: 350px; margin: 0 auto; border: 1px solid red;'>
				</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="main-block">
			<h3 class="text-center"><?= $author->name ?></h3>
			<p style="color: #444; font-size: 16px; line-height: 1.2em; padding: 7px 15px;">
				<?= Html::encode($author->biography) ?>
			</p>
		</div>
		<div class="main-block">
			<h3 class="text-center">Книги</h3>
			
			<?php if (!$author->books): ?>
				<p class="text-center">Вы не добавляли книги на сайт</p>
			<?php endif; ?>
			
			<br>

			<?php foreach($author->books as $book): ?>
				<div class="book_in_list" style="margin-bottom: 10px;">
					<?= Html::a("<div class='image' title='". $book['name'] ."' style='background: url(/images/books/". $book['image'] .") no-repeat center; background-size: contain; width: 200px; height: 200px;'></div>", ['book/view', 'id' => $book['id']]) ?>
				</div>
			<?php endforeach; ?>

			<div class="clear_after_block"></div>
		</div>
	</div>
</div>
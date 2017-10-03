<?php
use yii\helpers\Html;
?>

<h2 class="text-center">Авторы</h2>

<?php if (!$data): ?>
	<p class="text-center">
		Вы не добавляли авторов на сайт
	</p>
<?php endif; ?>
<br>

<div class="row">

<?php foreach($data as $author): ?>
	<div class="col-ls-12 col-xs-6 col-md-4 col-lg-3">

		<div class="author_in_list">
			<div class="author_image" title="<?= $author['name'] ?>" style="background: url(/images/authors/<?= $author['image'] ?>) no-repeat center; background-size: contain;"></div>
			<p><?= Html::a($author['name'], ['author/view', 'id' => $author['id']]) ?></p>
			<br>
		</div>

	</div>
<?php endforeach; ?>

</div>

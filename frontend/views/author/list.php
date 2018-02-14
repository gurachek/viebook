<?php
use yii\helpers\Html;

$this->title = "Cписок авторов, доступных на Viebook";

$this->registerJs("jQuery('.layout').addClass('main-block')");

?>

<h3 class="text-center">Список всех авторов, которые есть на сайте на данный момент</h3>
<br>

<?php if (!$authors): ?>

	<p class="text-center">
		Я все удалил и буду добавлять авторов тех книг, которые сейчас необходимы для развития сайта 
	</p>

<?php else: ?>

<div class="row">

	<?php foreach($authors as $author): ?>
		<div class="col-lg-3 col-md-4 col-ls-4 col-xs-6">
			<?= Html::a("
			<div title='{$author->name}' style='background: url(/images/authors/{$author->image}) no-repeat center; background-size: contain; width: 200px; height: 200px; margin: 0 auto;'>
			</div>", ['author/view', 'id' => $author->id]);
			?>
			<p style="margin-top: 5px;" class="text-center" style="margin-bottom: 25px;"><?= $author->name ?></p>
		</div>

	<?php endforeach; ?>

</div>

<?php endif; ?>
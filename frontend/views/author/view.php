<?php
use yii\helpers\Html;

$this->title = $author->name . " - Viebook";
?>

<div class="row">
	<div class="col-md-5">
		<h3 class="text=center"><?= $author->name ?></h3>
		<div title='<?= $author->name ?>' style='background: url(/images/authors/<?= $author->image ?>) no-repeat; background-size: contain; width: 200px; height: 200px; margin: 0 auto;'>
			</div>
	</div>
	<div class="col-md-5">
		
	</div>
</div>
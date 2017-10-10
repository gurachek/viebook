<?php
use yii\helpers\Html;

$this->title = 'Admin panel';
?>

<div class="row">
	<div class="col-md-6">
		<p class="text-center">
			<?= Html::a('Reviews', ['reviews']); ?>
		</p>
	</div>
	<div class="col-md-6">
		<p class="text-center">
			<?= Html::a('Emails', ['emails']); ?>
		</p>
	</div>
</div>
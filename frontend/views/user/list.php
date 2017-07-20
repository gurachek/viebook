<?php
use yii\helpers\Html;

$this->title = "Пользователи Viebook";
?>

<h3 class="text-center">Наши пользователи</h3>
<br>

<div class="row">

	<?php foreach($users as $user): ?>
		<div class="col-lg-3 col-md-4 col-ls-4 col-xs-6">
			<?= Html::a("
			<div title='{$user->name}' style='background: url(images/users/{$user->image}) no-repeat center; background-size: cover; width: 200px; height: 200px; margin: 0 auto; border-radius: 100px;'>
			</div>", ['user/view', 'id' => $user->id]);
			?>
			<p class="text-center" style="margin-bottom: 25px;"><?= $user->getName() ?></p>
		</div>

	<?php endforeach; ?>

</div>
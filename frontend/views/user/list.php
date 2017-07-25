<?php
use yii\helpers\Html;

$this->title = "Пользователи Viebook";
?>

<h3 class="text-center">Наши пользователи</h3>
<br>

<div class="row">

	<?php foreach($users as $user): ?>
		<div class="col-lg-3 col-md-4 col-ls-4 col-xs-6" class="user_list_avatar">
			<?= Html::a("<div></div>", ['user/view', 'id' => $user->id], [
				'title' => $user->name,
				'style' => 'background: url(/images/users/'.$user->image.') no-repeat center; background-size: cover;>',
				'class' => 'user_list_avatar',
			]);
			?>
			<p class="text-center" style="margin-bottom: 25px;"><?= $user->getName() ?></p>
		</div>

	<?php endforeach; ?>

</div>

<?php
use yii\helpers\Html;

$this->title = Yii::$app->user->identity->getName() . ' | Viebook';

?>

<div class="row">
	<div class="col-md-3 col-md-push-9 main-block">
		<br>
		<div class="user_account_image" style="background: url(/images/users/<?= $user->image ?>) no-repeat center; background-size: cover;"></div>
		<div class="user_logout" title="Выход">
			<?= Html::beginForm(['/site/logout'], 'post') ?>
				<?= Html::submitButton('<span class="glyphicon glyphicon-log-out" style="color: #E64354;"></span>', ['class' => 'btn btn-link']) ?>
			<?= Html::endForm() ?>
			</div>
		<br>

		<p class="text-center" style="font-size: 17px;">
			<?= $user->getName(); ?>
			<br>
			<small style="color: gray;">Rating: <?= $user->rating ?></small>
		</p>

		<ul class="user_menu" style="width: 80%; margin: 0 auto;">

			<li>
				<span class="glyphicon glyphicon-bell"></span>
				<?= Html::a('Feed list', ['user/index']) ?>
			</li>
			<li>
				<span class="glyphicon glyphicon-pushpin"></span>
				<?= Html::a('Pinned', ['user/index', 'content' => 'pinned']) ?>
			</li>
			<li>
				<span class="glyphicon glyphicon-list-alt"></span>
				<?= Html::a('My Reviews', ['user/index', 'content' => 'reviews']) ?>
			</li>
			<li>
				<span class="glyphicon glyphicon-cog"></span>
				<?= Html::a('Settings', ['user/index', 'content' => 'settings']) ?>		
			</li>

		</ul>
	</div>
	<div class="col-md-9 col-md-pull-3 user-account-content">
		<div id="main-block" class="main-block" style="padding: 10px;">
			<?php
				if ($user->active) {
					echo $this->render('content-'.$content, ['data' => $data]);
				} else {
					echo $this->render('no-active-profile', ['email' => $user->email]);
				}
			?>
		</div>
	</div>
</div>

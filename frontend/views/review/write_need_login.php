<?php
use yii\helpers\Html;
?>
<h3 class="text-center">Войдите в свой аккаунт, чтобы написать рецензию
<br>
<br>
<?= Html::a('Login', ['site/login', 'a' => 'write_review', 'id' => $bookid], ['class' => 'btn btn-default']); ?>
</h3>

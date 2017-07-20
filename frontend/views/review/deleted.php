<?php
use yii\helpers\Url;

$urlTo = Url::to(['user/index']);

$meta = [
    'http-equiv' => 'Refresh',
    'content' => '1; url=' . $urlTo,
];

\Yii::$app->view->registerMetaTag($meta);
$this->title = "Рецензия была удалена";
?>
<h4 class="text-center">Ваша рецензия удалена</h4>
<p class="text-center">
	Сейчас Вы будете перенаправлены в свой личный кабинет
</p>
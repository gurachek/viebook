<?php 
$this->title = "База email-адресов";

$this->registerJs("jQuery('.layout').addClass('main-block')");
?>

<h3>Всего собрано адресов: <?= $count; ?></h3>

<?php foreach($emails as $email): ?>

<?= $email['email'] ?><br>

<?php endforeach; ?>
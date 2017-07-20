<?php
use yii\helpers\Html;

$this->title = "Cписок книг, доступных на Viebook";
?>

<?php foreach($books as $book): ?>
	<?= $book['name'] ?>
	<br>
<?php endforeach; ?>
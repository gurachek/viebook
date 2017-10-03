<?= $this->render('content-books', ['data' => $data['books']]); ?>

<br>

<?= $this->render('content-authors', ['data' => $data['authors']]); ?>

<br>

<?= $this->render('content-reviews', ['data' => $data['reviews']]); ?>

<?php
use yii\helpers\Html;

$this->title = 'Viebook - main page';
?>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h4><?= Html::a('Review', ['review/index']) ?></h4>
            <h4><?= Html::a('Author', ['author/index']) ?></h4>
            <h4><?= Html::a('Book', ['book/index']) ?></h4>
            <h4><?= Html::a('Category', ['category/index']) ?></h4>
            <h4><?= Html::a('Search', ['search/index']) ?></h4>
            <h4><?= Html::a('User', ['user/index']) ?></h4>
        </div>
        <div class="col-md-9">

            <?php

            $feed = [
                [
                    'id' => 1,
                    'title' => 'Book1',
                    'desc' => 'Lorem ipsum sit dolor amet. Lotu prometeus de van urenga tur.',
                ],
                [
                    'id' => 2,
                    'title' => 'Book2',
                    'desc' => 'Chto delat so svoej zhiznyu esli volodya ne hochey delat design. Eto ochen plachevno',
                ],
            ];

            ?>

            <?php foreach($feed as $single): ?>

                <h3><?= Html::a($single['title'], ['review/view', 'id' => $single['id']]) ?></h3>
                <p style="color: gray;">
                    <?= $single['desc'] ?>
                </p>
                <br>

            <?php endforeach; ?>
        </div>
    </div>
</div>

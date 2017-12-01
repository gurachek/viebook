<?php 
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$url = Yii::$app->getUrlManager()->createAbsoluteUrl(['search/books']);
$btn_url = Yii::$app->getUrlManager()->createAbsoluteUrl(['review/write']);

$js = <<<JS

document.getElementById("search").oninput = function() {

	var inputText = jQuery('#search').val();

	if (inputText.length >= 3) {

		jQuery.ajax({
			url: "$url",
			type: "POST",
			data: {
				text: inputText,
			},
			success: function (data) {

				var book = jQuery.parseJSON(JSON.stringify(data));

				document.getElementById('image').style.backgroundImage = 'url(/images/books/' + data['book']['image'] + ')';

				jQuery('#image').css('opacity', '1');


				jQuery('.book_info .name .label1').html(data['book']['name']);
				jQuery('.book_info .author .label1').html(data['author']);
				jQuery('.book_info .published_date .label1').html(data['book']['publish_date']);
				jQuery('.book_info .pages .label1').html(data['book']['pages']);
				jQuery('.book_info .book_level .label1').html(data['book_level']);
				jQuery('.book_info .category .label1').html(data['category']);
				jQuery('.book_info .reviews_count .label1').html(data['reviews_count']);

				jQuery('.write_review_button').css('display', 'block');
				jQuery('.write_review_button a').attr('href', '$btn_url?bookid=' + data['book']['id']);

			},
			error: function () {
				document.getElementById('image').style.backgroundImage = 'url(/images/books/no-photo.jpg)';

				jQuery('#image').css('opacity', '0.4');


				jQuery('.book_info .name .label1').html("%Book name%");
				jQuery('.book_info .author .label1').html("%Author name%");
				jQuery('.book_info .published_date .label1').html("%Publish date%");
				jQuery('.book_info .pages .label1').html("%Pages%");
				jQuery('.book_info .book_level .label1').html("%Book level%");
				jQuery('.book_info .category .label1').html("%Category%");
				jQuery('.book_info .reviews_count .label1').html("%Reviews count%");

				jQuery('.write_review_button').css('display', 'none');

			},
		});

	}

};

JS;

$this->registerJS($js);

?>
<div class="modal-find-book" style="padding: 10px;">
	<h4 class="text-center">Введите название книги, на которую хотите написать рецензию</h4>

	<div style="padding-top: 5px; width: 80%; margin: 0 auto">
        <input id="search" type="text" placeholder="Начните вводить название книги..." class="form-control">
    </div>

	<br>

	<div class="row">
		<div class="col-md-1"></div>
    	<div class="col-md-4">
    		<div id="image" style="background: url(/images/books/no-photo.jpg) no-repeat; background-size: contain; width: 100%; height: 400px; opacity: 0.4" title=""></div>
    	</div>
    	<div class="col-md-7">
    		<div class="book_info">
	    		<div class="name" style="color: #444;">
	    			Название книги:
	    			<span class="label1">%Book name%</span>
	    		</div>
	    		<div class="author">
	    			Автор:
		    		<span class="label1">%Author name%</span>
		    	</div>
	    		<div class="published_date">
	    			Дата публикации:
		    		<span class="label1">%Published date%</span>
		    	</div>
	    		<div class="pages">
	    			Кол-во страниц:
		    		<span class="label1">%Pages%</span>
		    	</div>
	    		<div class="book_level">
	    			Уровень книги:
		    		<span class="label1">%Book level%</span>
		    	</div>
	    		<div class="category">
	    			Категория:
		    		<span class="label1">%Category%</span>
		    	</div>
	    		<div class="reviews_count">
	    			Количество рецензий:
		    		<span class="label1">%Reviews count%</span>
		    	</div>
	    		<div class="write_review_button" style="margin-top: 5%; width: 100px;">
	    			<?= Html::a('Написать рецензию <span class="glyphicon glyphicon-new-window"></span>', ['review/write'], ['class' => 'btn btn-default']); ?>
	    		</div>

	    	</div>
    	</div>
	</div>

</div>
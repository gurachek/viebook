<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use frontend\models\Book;
use frontend\models\Tags;
use frontend\models\BookTags;
use frontend\models\BookTrack;
use frontend\models\Author;

class AddbookModel extends Model
{
	public $name;
	public $image;
	public $author;
	public $publish_date;
	public $tags;

	public function rules()
	{
		return [
			['name', 'required', 'message' => 'Люди часто ищут книги по названию. Пожалуйста, не игнорируйте это'],
			['author', 'required', 'message' => 'Нам нужно знать кто автор этой книги'],
			['publish_date', 'required', 'message' => 'Не знаю зачем, но это тоже нам нужно'],
			['tags', 'required', 'message' => 'На основе тагов мы составляем фид-ленту и разделы, введите пожалуйста'],
			['image', 'required', 'message' => 'Вы должны загрузить обложку, чтобы добавить книгу на сайт'],
			[['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
			[['image'], 'file', 'maxSize' => '100000'],
			[['image'], 'file', 'maxFiles'=> 1],
		];
	}

	public function add()
	{
		if ($this->validate()) {

			$issetBook = Book::findOne(['like', 'name', $this->name]);

			if (!$issetBook) {
				$book = new Book();

				if (!$authorId = $book->getAuthorIdByName($this->author)) {
					$author = new Author();
					$author->name = $this->author;
					$author->save();

					$authorId = $author->id;
				}

				$book->name = htmlspecialchars($this->name);
				$book->image = $this->image->baseName . '.' . $this->image->extension;
				$book->author_id = $authorId;
				$book->publish_date = $this->publish_date;
				$book->category = 2;

				$book->save();

				$tags = explode(',', $this->tags);

				foreach($tags as $tag) {
					$tag = trim($tag);

					if (!$issetTag = Tag::findOne(['name' => $tag])) {
						$issetTag = new Tag();
						$issetTag->name = $tag;
						$issetTag->save();
					}

					$bookTag = new BookTags();
					$bookTag->book_id = $book->id;
					$bookTag->tag_id = $issetTag->id;

					$bookTag->save();
				}

				$track = new BookTrack();
				$track->user_id = Yii::$app->user->getId();
				$track->book_id = $book->id;
				$track->time = time();
				$track->save();

				Yii::$app->user->identity->increaseRating(2);

				$this->image->saveAs(Yii::getAlias('@webroot') . '/images/books/' . $this->image->baseName . '.' . $this->image->extension);

				return true;
			}
		}

		return false;
	}
}

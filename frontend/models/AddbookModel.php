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
	public $author;
	public $category;
	public $publish_date;
	public $tags;
	public $image;
	public $level;
	public $pages;
	public $active;

	public function rules()
	{
		return [
			['name', 'required', 'message' => 'Люди часто ищут книги по названию. Пожалуйста, не игнорируйте это'],
			['name', 'unique', 'targetClass' => 'frontend\models\Book', 'message' => 'Эта книга уже есть на сайте'],
			['author', 'required', 'message' => 'Нам нужно знать кто автор этой книги'],
			['publish_date', 'required', 'message' => 'Не знаю зачем, но это тоже нам нужно'],
			['tags', 'required', 'message' => 'На основе тегов мы составляем фид-ленту и разделы, введите пожалуйста'],
			['category', 'required', 'message' => 'Это важно, нельзя оставлять это поле пустым'],
			['image', 'required', 'message' => 'Вам нужно загрузить обложку, чтобы добавить книгу на сайт'],
			['pages', 'required', 'message' => 'Пожалуйста, укажите количество страниц'],
			['level', 'required', 'message' => 'Нам нужно знать уровень книги, чтобы подбор книг был точнее'],
			[['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
			[['image'], 'file', 'maxSize' => '5000000'],
			[['image'], 'file', 'maxFiles'=> 1],
		];
	}

	public function add()
	{
		if ($this->validate()) {

			$issetBook = Book::findOne(['like', 'name', $this->name]);

			if (!$issetBook) {
				$book = new Book();

				$authorId = $this->getAuthorId($book);

				$image = time() . '.' . $this->image->extension;

				$this->image->saveAs(Yii::getAlias('@webroot') . '/images/books/' . $image);

				$book->name = htmlspecialchars($this->name);
				$book->image = $image;
				$book->pages = intval($this->pages);
				$book->level_id = intval($this->level);
				$book->author_id = $authorId;
				$book->publish_date = $this->publish_date;
				$book->category = $this->category;

				$book->active = 0;

				if ($book->save())
					if ($this->addTags($book))
						if ($this->track($book))
							return true;
			}
		}

		return false;
	}

	private function getAuthorId(Book $book)
	{
		if (!$authorId = $book->getAuthorIdByName($this->author)) {
			$author = new Author();
			$author->name = $this->author;
			$author->image = 'no-photo.gif'; 
			$author->save();

			return $author->id;
		}

		return false;
	}

	private function track(Book $book)
	{
		$track = new BookTrack();
		$track->user_id = Yii::$app->user->getId();
		$track->book_id = $book->id;
		$track->time = time();

		Yii::$app->user->identity->increaseRating(2);

		return $track->save() ?? false;
	}

	private function addTags(Book $book)
	{
		$tags = explode(',', $this->tags);
		foreach($tags as $tag) {
			$tag = trim($tag);

			if (!$tag) {
				continue;
			}

			if (!$issetTag = Tag::findOne(['name' => $tag])) {
				$issetTag = new Tag();
				$issetTag->name = $tag;
				$issetTag->save();
			}

			$bookTag = new BookTags();
			$bookTag->book_id = $book->id;
			$bookTag->tag_id = $issetTag->id;

			return $bookTag->save();
		}

		return false;
	}
}

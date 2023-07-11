<?php

namespace app\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property int               $id
 * @property string|null       $title
 * @property string|null       $releaseDate
 * @property string|null       $description
 * @property int|null          $isbn
 * @property-read  ActiveQuery $authors
 */
class Book extends ActiveRecord
{

    /**
     * @var UploadedFile|null|string
     */
    //todo research framework typed property issue 
    public $coverImageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['coverImageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg'],
            [['releaseDate'], 'safe'],
            [['description'], 'string'],
            [['isbn'], 'integer', 'max' => 9999999999999],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['id' => "string", 'title' => "string", 'releaseDate' => "string", 'description' => "string", 'isbn' => "string", 'coverImageFile' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id'             => 'ID',
            'title'          => 'Title',
            'releaseDate'    => 'Release Date',
            'description'    => 'Description',
            'isbn'           => 'Isbn',
            'coverImageFile' => 'Cover image'
        ];
    }

    public function upload(): bool
    {
        if ($this->validate()) {
            $this->coverImageFile->saveAs('uploads/' . $this->id . '.' . $this->coverImageFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }

    public function beforeSave($insert): bool
    {
        if (strlen($this->releaseDate) == 4) {
            $this->releaseDate = $this->releaseDate . '-01-01';
        }

        return parent::beforeSave($insert);
    }

    function getCoverUrl(): string
    {
        return '/uploads/' . $this->id . '.jpg';
    }

    function saveAuthors(array $authors)
    {
        //todo discuss real needing authors deletion, on mistake delete whole book record & create new
        foreach ($authors as $author_id) {
            $bookAuthor = new BookAuthor([
                'book_id'   => $this->id,
                'author_id' => $author_id
            ]);
            try {
                $bookAuthor->save();
            } catch (\Throwable $error) {
                //todo add error handler
            }
        }
    }
}

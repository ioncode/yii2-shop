<?php

namespace app\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author".
 *
 * @property int         $id
 * @property string|null $title
 * @property string|null $body
 * @property-read int    $bookCount
 * @property-read int    $books
 */
class Author extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['id' => "string", 'title' => "string", 'body' => "string", 'bookCount'=>"string"])]
    public function attributeLabels(): array
    {
        return [
            'id'        => 'ID',
            'title'     => 'Title',
            'body'      => 'Description',
            'bookCount' => 'Overall books released'
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    function getBookCount(): int
    {
        return $this->getBooks()->count();
    }

    /**
     * @throws InvalidConfigException
     */
    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('book_author', ['author_id' => 'id']);
    }
}

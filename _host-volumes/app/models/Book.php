<?php

namespace app\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "book".
 *
 * @property int         $id
 * @property string|null $title
 * @property string|null $releaseDate
 * @property string|null $description
 * @property int|null    $isbn
 */
class Book extends ActiveRecord
{
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
            [['releaseDate'], 'safe'],
            [['description'], 'string'],
            [['isbn'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['id' => "string", 'title' => "string", 'releaseDate' => "string", 'description' => "string", 'isbn' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id'          => 'ID',
            'title'       => 'Title',
            'releaseDate' => 'Release Date',
            'description' => 'Description',
            'isbn'        => 'Isbn',
        ];
    }
}

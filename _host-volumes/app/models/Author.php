<?php

namespace app\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author".
 *
 * @property int         $id
 * @property string|null $title
 * @property string|null $body
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
    #[ArrayShape(['id' => "string", 'title' => "string", 'body' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id'    => 'ID',
            'title' => 'Title',
            'body'  => 'Body',
        ];
    }
}

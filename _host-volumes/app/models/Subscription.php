<?php

namespace app\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscription".
 *
 * @property int         $id
 * @property int         $phone
 * @property int         $author_id
 * @property string|null $guest_uuid
 * @property Author      $author
 */
class Subscription extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['phone', 'author_id'], 'required'],
            [['phone', 'author_id'], 'integer'],
            [['guest_uuid'], 'string', 'max' => 36],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape(['id' => "string", 'phone' => "string", 'author_id' => "string", 'guest_uuid' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id'         => 'ID',
            'phone'      => 'Phone',
            'author_id'  => 'Author ID',
            'guest_uuid' => 'Guest Uuid',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function createNotification(Book $book)
    {
        try {
            $notification = new Notification([
                'subscription_id' => $this->id,
                'text'            => 'Added book «' . $book->title . '»! Find it at http://localhost:8202/book/view?id=' . $book->id
            ]);
            $notification->save();
        } catch (\Throwable $exception){
            //todo add logger
        }


    }
}

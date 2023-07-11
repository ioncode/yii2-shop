<?php

namespace app\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notification".
 *
 * @property int          $id
 * @property int          $subscription_id
 * @property string       $create_time
 * @property string|null  $update_time
 * @property string|null  $text
 * @property int          $status
 * @property string|null  $result
 * @property Subscription $subscription
 */
class Notification extends ActiveRecord
{
    const STATUS_CREATED = 1;
    const STATUS_SENT = 2;
    const STATUS_RECEIVED = 3;
    const STATUS_RETRY = 4;
    const STATUS_ERROR = 5;
    const RETRY_COUNT = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['subscription_id'], 'required'],
            [['subscription_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['result'], 'string'],
            [['text'], 'string', 'max' => 255],
            [['subscription_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscription::class, 'targetAttribute' => ['subscription_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    #[ArrayShape([
        'id'   => "string", 'subscription_id' => "string", 'create_time' => "string", 'update_time' => "string",
        'text' => "string", 'status' => "string", 'result' => "string"
    ])]
    public function attributeLabels(): array
    {
        return [
            'id'              => 'ID',
            'subscription_id' => 'Subscription ID',
            'create_time'     => 'Create Time',
            'update_time'     => 'Update Time',
            'text'            => 'Text',
            'status'          => 'Status',
            'result'          => 'Result',
        ];
    }

    /**
     * Gets query for [[Subscription]].
     *
     * @return ActiveQuery
     */
    public function getSubscription(): ActiveQuery
    {
        return $this->hasOne(Subscription::class, ['id' => 'subscription_id']);
    }
}

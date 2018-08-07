<?php
namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @property Event $event
 * @property User $user
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'user_id'], 'required'],
            [['event_id', 'user_id'], 'integer'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'user_id' => 'User ID',
        ];
    }
    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    /**
     * @return ActiveQuery
     */
    public function getEvent(): ActiveQuery
    {
        return $this->hasOne(Event::class, ['id' => 'event_id']);
    }

    /**
     * @param Event $event
     * @param int $userId
     * @return void
     */
    public static function saveAccess(Event $event, int $userId)
    {
        $access = new self();
        $access->setAttributes([
            'event_id' => $event->id,
            'user_id' => $userId,
        ]);
        $access->save();
    }
}
<?php
namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property int $note_id
 * @property int $user_id
 * @property Note $note
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
            [['note_id', 'user_id'], 'required'],
            [['note_id', 'user_id'], 'integer'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'note_id' => 'Note ID',
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
    public function getNote(): ActiveQuery
    {
        return $this->hasOne(Note::class, ['id' => 'note_id']);
    }

    /**
     * @param Note $note
     * @param int $userId
     *
     * @return void
     */
    public static function saveAccess(Note $note, int $userId)
    {
        $access = new self();
        $access->setAttributes([
            'note_id' => $note->id,
            'user_id' => $userId,
        ]);
        $access->save();
    }
}
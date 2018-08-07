<?php

namespace app\models;

use Yii;
use app\models\queries\EventQuery;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int $ids
 * @property string $name Наименование
 * @property string $start_at Начало напоминания
 * @property string $end_at Окончание напоминания
 * @property string $created_at Создано
 * @property string $updated_at Последнее обновление
 * @property int $author_id
 */
class Event extends \yii\db\ActiveRecord
{
    public $ids = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    public static function find(): EventQuery
    {
        return new EventQuery(get_called_class());
    }

    public function beforeSave($insert): bool
    {
        if (!$this->author_id) {
            $this->author_id = \Yii::$app->getUser()->getId();
        }
        return parent::beforeSave($insert);
    }

    //	public function behaviors()
//	{
//		return [
//			'timestamp' => [
//				'class' => TimestampBehavior::class,
//				'createdAtAttribute' => 'created_at',
//				'updatedAtAttribute' => 'updated_at',
//			],
//		];
//	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['ids', 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['author_id', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'start_at' => 'Начало напоминания',
            'end_at' => 'Окончание напоминания',
            'created_at' => 'Создано',
            'updated_at' => 'Последнее обновление',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }
}

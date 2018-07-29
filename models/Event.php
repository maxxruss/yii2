<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;


/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name Наиманование
 * @property string $start_at Начало напоминания
 * @property string $end_at Окончание напоминания
 * @property string $created_at Создано
 * @property string $updated_at Последнее обновление
 * @property int $author_id
 * @property User $author
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наиманование',
            'start_at' => 'Начало напоминания',
            'end_at' => 'Окончание напоминания',
            'created_at' => 'Создано',
            'updated_at' => 'Последнее обновление',
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

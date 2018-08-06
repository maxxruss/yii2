<?php

namespace app\models;

use Yii;
use app\models\queries\EventQuery;


/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property string $name Наименование
 * @property string $start_at Начало напоминания
 * @property string $end_at Окончание напоминания
 * @property string $created_at Создано
 * @property string $updated_at Последнее обновление
 * @property int $author_id
 */
class Event extends \yii\db\ActiveRecord
{
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'start_at', 'end_at', 'author_id'], 'required'],
            [['start_at', 'end_at', 'created_at', 'updated_at'], 'safe'],
            [['author_id'], 'integer'],
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
            'name' => 'Наименование',
            'start_at' => 'Начало напоминания',
            'end_at' => 'Окончание напоминания',
            'created_at' => 'Создано',
            'updated_at' => 'Последнее обновление',
            'author_id' => 'Author ID',
        ];
    }
}

<?php

namespace app\models\forms;

use app\models\Event;
use app\models\User;
use app\models\Access;


class EventForm extends Event
{
    public $users = [];

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = ['users', 'checkUser'];
        return $rules;
    }

    /**
     * @return void
     */
    public function checkUser()
    {
        foreach ($this->users as $userId) {
            $count = (int)User::find()->andWhere(['id' => $userId])->count('id');
            if ($count === 0) {
                $this->addError('users', \sprintf('Пользователя с ID=%d не существует', $userId));
            }
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->users = Access::find()->select(['user_id'])->andWhere(['event_id' => $this->id])->column();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Access::deleteAll(['event_id' => $this->id]);
        foreach ($this->users as $userId) {
            Access::saveAccess($this, $userId);
        }
    }
}
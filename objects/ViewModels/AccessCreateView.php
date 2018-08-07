<?php
namespace app\objects\ViewModels;
use app\models\Event;
use app\models\User;
use yii\helpers\BaseArrayHelper;

class AccessCreateView
{
    /**
     * @return array
     */
    public function getNoteOptions(): array
    {
        $models = Event::find()->all();
        return BaseArrayHelper::map($models, 'id', 'name');
    }
    /**
     * @return array
     */
    public function getUserOptions(): array
    {
        $models = User::find()->all();
        return BaseArrayHelper::map($models, 'id', 'username');
    }
}
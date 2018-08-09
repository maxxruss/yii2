<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 09.08.2018
 * Time: 20:54
 */

namespace app\widgets;

use yii\base\Widget;

class MyWidget extends Widget
{
    public $var = 'super';

    public function run()
    {
        return $this->render('@app/views/widgets/myView', [
            'var' => $this->var,
        ]);
    }
}
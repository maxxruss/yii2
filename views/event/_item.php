<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

use yii\grid\GridView;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Event;
//use yii\bootstrap\DatePicker;

use yii\jui\DatePicker;



/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

  var_dump($model->name);
echo $index;
echo $key;
?>
<div class="post">
    <h2><?= Html::encode($this->title) ?></h2>

    <?= HtmlPurifier::process($this->title) ?>
    <?= DatePicker::widget(['name' => 'date']) ?>
</div>



<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\Event;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    /**var_dump($days);
    exit;

    foreach ($days as $day => $notes) {
    			$count = count($notes);
        echo($count).'<br>';
    			//echo $count.'<br>';
    		}
exit;**/
    ?>

    <?= ListView::widget([
        'dataProvider' => $days,
        'itemView' => '_item',
        'viewParams' => [
            'fullView' => true,
            'context' => 'main-page',
            // ...
        ],
        ]);
    ?>
</div>

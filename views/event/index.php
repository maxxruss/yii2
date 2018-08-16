<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\widgets\ListView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    /**d($dataProvider);
    exit;**/
    GridView::widget([
        'dataProvider' => $dataProvider,
        //'itemView' => '_item',
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name:raw',
            'author_id:raw',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} ',
                'visibleButtons' => [
                    //'delete' => false
                ],
            ]
        ],
    ]);?>
    <?=\app\widgets\MyWidget::widget([
    ]);?>


</div>

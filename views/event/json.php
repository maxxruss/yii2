<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\Event */

//$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
это JSON
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= print_r($model)?>



</div>

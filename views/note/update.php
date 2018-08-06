<?php

use yii\helpers\Html;
use app\objects\ViewModels\NoteCreateView;


/* @var $this yii\web\View */
/* @var $model app\models\Note */
/* @var $viewModel NoteCreateView */


$this->title = 'Update Note: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="note-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'viewModel' => $viewModel,

    ]) ?>

</div>

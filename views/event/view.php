<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\objects\ViewModels\EventView;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $viewModel EventView */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($viewModel->canWrite($model)): ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php endif; ?>

    <?php if ($this->beginCache('note-view-time', ['duration' => 60])):?>
        <div>
            Текущее время:
            <?=date('d.m.Y H:i:s');?>
        </div>
        <?=$this->endCache();?>
    <?php endif;?>

<?php if ($this->beginCache('event-view-time1', ['duration'=>60])):?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_at',
            'updated_at',
            'author_id',
        ],
    ]) ?>
    <?= $this->endCache();?>
    <?php endif; ?>

</div>

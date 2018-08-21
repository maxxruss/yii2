<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\objects\ViewModels\EventCreateView;
use kartik\widgets\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
/* @var $viewModel EventCreateView */

?>

<div class="event-form">

    <?php $form = ActiveForm::begin();
    //d($model, $viewModel);exit;?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'users')
        ->checkboxList($viewModel->getUserOptions(), ['separator' => '<br/>'])
        ->label('Пользователи')
        ->hint('Пользователи, которые будут иметь доступ к заметке')
    */?>

    <?= $form->field($model, 'users')->widget(Select2::class, [
        'data' => $viewModel->getUserOptions(),
        'options' => [
            'multiple' => true,
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

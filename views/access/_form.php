<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\objects\ViewModels\AccessCreateView;

/* @var $this yii\web\View */
/* @var $model app\models\Access */
/* @var $form yii\widgets\ActiveForm */
/* @var $viewModel AccessCreateView */

?>

<div class="access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Event_id')->dropDownList($viewModel->getNoteOptions()) ?>

    <?= $form->field($model, 'user_id')->dropDownList($viewModel->getUserOptions()) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
use app\models\forms\EventForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/* @var $model EventForm */
?>

<?php $form = ActiveForm::begin();?>
<?=$form->field($model, 'name')->textInput();?>

<?=$form->field($model, 'username')->textInput();?>
<?=$form->field($model, 'password')->passwordInput();?>

<?=Html::submitButton('Сохранить');?>
<?php ActiveForm::end();?>
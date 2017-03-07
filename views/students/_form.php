<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Students */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="students-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
    	'language' => 'pt-BR',
        //'inline' => true,
    	'dateFormat' => 'dd/MM/yyyy',
    	'clientOptions' => [
    		'changeMonth' => true,
		    'yearRange' => '1986:'.date('Y'),
		    'changeYear' => true,
		    //'showOn' => 'button',
		    //'buttonImage' => 'images/calendar.gif',
		    'buttonImageOnly' => true,
		    //'buttonText' => 'Select date'
    	],
        //'containerOptions' => [
            //'class' => 'form-control'
        //],

    ]) ?>

    <?= $form->field($model, 'schedule')->dropDownList($shedules) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Novo') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

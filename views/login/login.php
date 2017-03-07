<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>  
    <div class="col-lg-5 login-box">
    <div class="well well-lg">
        <div class="row">
            <p class="titulo-login">Faça Seu Login :</p>
            <div class="col-lg-12">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']);  ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Senha'])->label('Senha') ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group button-login">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
   </div>    


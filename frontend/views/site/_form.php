<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Application */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'FIO')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput() ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'message')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className()) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

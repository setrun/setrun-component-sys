<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this  yii\web\View */
/* @var $model setrun\sys\forms\backend\DomainForm */
/* @var $form  yii\widgets\ActiveForm */
/* @var $side  string */
?>

<div class="domain-form">
    <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label'   => 'col-sm-2',
                    'wrapper' => 'col-sm-10',
                ],
            ],
    ]); ?>
    <div class="box">
        <div class="box-body">
            <p class="pull-right">
                <?= Html::submitButton(
                    '<i class="fa fa-check"></i> ' . Yii::t('setrun/backend', 'Save'),
                    ['class' => 'btn btn-primary ' . ($side == 'edit' ? 'ajax-submit-button' : '')]) ?>
            </p>
            <div class="clearfix"></div>
            <hr/>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

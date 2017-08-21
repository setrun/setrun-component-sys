<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use setrun\sys\entities\Language;
use setrun\sys\helpers\FileHelper;
use setrun\sys\helpers\LanguageHelper;
use setrun\sys\assets\backend\LanguageAsset;

/* @var $this  yii\web\View */
/* @var $model setrun\sys\entities\manage\Language */
/* @var $form  yii\widgets\ActiveForm */
/* @var $side  string */

Icon::map($this, Icon::FI);
LanguageAsset::register($this, [
    'js/language/form.js',
    'css/language/form.css'
]);
?>

<div class="language-form">
    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => [
            'labelSpan'  => 2,
            'deviceSize' => ActiveForm::SIZE_SMALL
        ],
        'options' => [
            'class' => 'form'
        ]
    ]); ?>
    <div class="clearfix"></div>
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

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'locale')->textInput(['maxlength' => true]) ?>

            <div class="form-group field-languageform-icon" style="margin-bottom: 15px">
                <label class="col-sm-2 control-label" for="languageform-icon">
                    <?= $model->getAttributeLabel('icon') ?>
                </label>
                <div class="col-sm-10">
                    <select id="languageform-icon" class="form-control" name="LanguageForm[icon]">
                        <?php foreach (LanguageHelper::getCountries() as $code => $country) : ?>
                            <option <?php if ($model->icon == strtolower($code)) : ?> selected="selected" <?php endif; ?>
                                    data-img-src="<?= LanguageHelper::getIconUrl($code) ?>"
                                    value="<?= strtolower($code) ?>"><?= $country ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?= $form->field($model, 'status')->radioButtonGroup(Language::getStatuses(), [
                'itemOptions' => [
                    'labelOptions' => [
                            'class' => 'btn btn-dark'
                    ]
                ]
            ]);?>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

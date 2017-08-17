<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use setrun\sys\helpers\FileHelper;
use setrun\sys\helpers\LanguageHelper;
use setrun\sys\assets\backend\LanguageAsset;

/* @var $this  yii\web\View */
/* @var $model setrun\sys\entities\manage\Language */
/* @var $form  yii\widgets\ActiveForm */

LanguageAsset::register($this, ['js/language/form.js', 'css/language/form.css']);
Icon::map($this, Icon::FI);
?>

<div class="language-form">
    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]); ?>
    <div class="clearfix"></div>
    <div class="box">
        <div class="box-body">
            <p class="pull-right">
                <?= Html::submitButton('<i class="fa fa-check"></i> ' . Yii::t('setrun/backend', 'Save'), ['class' => 'btn btn-primary']) ?>
            </p>
            <div class="clearfix"></div>
            <hr/>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'locale')->textInput(['maxlength' => true]) ?>

            <div class="form-group field-language-icon" style="margin-bottom: 15px">
                <label class="control-label col-sm-2" for="language-icon_id"><?= $model->getAttributeLabel('icon_id') ?></label>
                <div class="col-sm-10">
                    <select id="language-icon" class="form-control" name="LanguageForm[icon_id]">
                        <?php foreach (LanguageHelper::getCountries() as $code => $country) : ?>
                            <option <?php if ($model->icon_id === strtolower($code)) : ?> selected="selected" <?php endif; ?>
                                    data-img-src="<?= LanguageHelper::getIconUrl($code) ?>"
                                    value="<?= strtolower($code) ?>"><?= $country ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?= $form->field($model, 'status')->radioButtonGroup(\setrun\sys\entities\Language::getStatuses(), [
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

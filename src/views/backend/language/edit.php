<?php

use yii\helpers\Html;

/* @var $this  yii\web\View */
/* @var $model setrun\sys\entities\manage\Language */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/language', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('setrun/sys/language', 'Edit');
?>
<div class="language-edit">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

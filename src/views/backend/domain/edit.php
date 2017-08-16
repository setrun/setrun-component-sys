<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model setrun\sys\entities\Domain */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/domain', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('setrun/sys/domain', 'Edit');
?>
<div class="domain-edit">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model setrun\sys\entities\Setting */

$this->title = Yii::t('setrun/sys/settring', 'Update {modelClass}: ', [
    'modelClass' => 'Setting',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/settring', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('setrun/sys/settring', 'Update');
?>
<div class="setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

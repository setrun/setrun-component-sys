<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model setrun\sys\entities\Language */

$this->title = Yii::t('setrun/sys/language', 'Update {modelClass}: ', [
    'modelClass' => 'Language',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/language', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('setrun/sys/language', 'Update');
?>
<div class="language-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

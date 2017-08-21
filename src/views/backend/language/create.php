<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model setrun\sys\entities\Language */

$this->title = Yii::t('setrun/sys/language', 'Create Language');
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/language', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-create">
    <?= $this->render('_form', [
        'model' => $model,
        'side'  => 'сreate'
    ]) ?>
</div>

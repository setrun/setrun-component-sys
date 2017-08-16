<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model setrun\sys\entities\Domain */

$this->title = Yii::t('setrun/sys/domain', 'Create Domain');
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/domain', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="domain-create">

            <?= $this->render('_form', ['model' => $model]) ?>

</div>

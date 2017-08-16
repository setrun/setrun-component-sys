<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model setrun\sys\entities\Language */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/language', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('setrun/sys/language', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('setrun/sys/language', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('setrun/sys/language', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'domain_id',
            'slug',
            'name',
            'locale',
            'alias',
            'icon_id',
            'bydefault',
            'status',
            'position',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

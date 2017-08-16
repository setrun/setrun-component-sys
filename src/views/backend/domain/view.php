<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model setrun\sys\entities\Domain */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('setrun/sys/domain', 'Domains'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="domain-view">
    <div class="box">
        <div class="box-body">
            <p class="pull-right">
                <?= Html::a('<i class="fa fa-pencil"></i> ' . Yii::t('setrun/backend', 'Edit'),   ['edit',  'id' => $model->id], ['class' => 'btn btn-default']) ?>
                <?= Html::a('<i class="fa fa-trash"></i> ' . Yii::t('setrun/backend', 'Delete'),  ['delete','id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => Yii::t('setrun/backend', 'Do you want to delete ?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <div class="clearfix"></div>
            <hr/>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'alias',
                    'url',
                    'created_at' => [
                        'attribute' => 'created_at',
                        'format'    => 'raw',
                        'value' => function($model, $index){
                            return  Yii::$app->formatter->asDate($model->created_at, 'long') . ' [<i>' . $model->getTimeAgo('created_at') . '</i>]';
                        }
                    ],
                    'updated_at' => [
                        'attribute' => 'updated_at',
                        'format'    => 'raw',
                        'value' => function($model, $index){
                            return  Yii::$app->formatter->asDate($model->updated_at, 'long') . ' [<i>' . $model->getTimeAgo('updated_at') . '</i>]';
                        }
                    ],
                    'created_by',
                    'updated_by',
                ],
            ]) ?>
        </div>
    </div>
</div>

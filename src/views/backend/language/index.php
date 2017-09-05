<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\icons\Icon;
use yii\grid\GridView;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;
use setrun\sys\entities\manage\Language;
use setrun\sys\assets\backend\LanguageAsset;
use kotchuprik\sortable\assets\SortableAsset;

/* @var $this         yii\web\View */
/* @var $searchModel  setrun\sys\forms\backend\search\LanguageSearchForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('setrun/sys/language', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
$this->params['pjaxID']        = 'language-index';

Icon::map($this, Icon::FI);
LanguageAsset::register($this);
?>
<div class="language-index">
    <div class="box">
        <div class="box-body">
            <p>
                <a href="<?= Url::to(['create']) ?>" class="btn btn-default">
                    <i class="fa fa-fw fa-plus"></i> <?= Yii::t('setrun/sys/language', 'Create Language') ?>
                </a>
                <a href="javascript:void(0)" class="btn btn-default" id="clear-filter">
                    <?= Icon::show('times', [], Icon::FA) ?>
                    <?= Yii::t('setrun/backend', 'Clear filters') ?>
                </a>
            </p>
            <hr />

            <?php Pjax::begin([
                    'id'      => $this->params['pjaxID'],
                    'timeout' => 3000
            ]);
            if (isset($_GET['_pjax'])) $_GET['_pjax'] = ''; ?>

            <?php
                SortableAsset::register($this);
                $this->registerJs('initSortableWidgets();', \yii\web\View::POS_READY, 'sortable');
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => [
                    'class' => 'table table-striped table-hover table-bordered'
                ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-sortable-id' => $model->id];
                },
                'options' => [
                    'data' => [
                        'sortable-widget' => 1,
                        'sortable-url'    => Url::to(['sorting']),
                    ]
                ],
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn'
                    ],
                    'icon' => [
                        'attribute' => 'icon',
                        'label' => '',
                        'format'    => 'raw',
                        'value'     => function($model, $index, $key){
                            return Icon::show($model->icon, [], Icon::FI);
                        },
                        'headerOptions' => [ 'style' => 'width: 5%']
                    ],
                    'name' => [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function($model, $index, $key){
                            $url     = ['edit', 'id' => $model->id];
                            $options = ['class' => '', 'data-pjax' => 0];
                            return Html::a($model->name, $url, $options);
                        }
                    ],
                    'updated_at' => [
                        'attribute' => 'updated_at',
                        'format'    => 'raw',
                        'value' => function($model, $index, $widget){
                            return $model->timeAgo;
                        },
                        'filter' => DateRangePicker::widget([
                            'model'         => $searchModel,
                            'attribute'     => 'updated_at',
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'locale' => ['format' => 'yy-m-d'],
                                'opens'  => 'left'
                            ],
                            'hideInput'      => false,
                            'presetDropdown' => true,
                        ])
                    ],
                    [
                        'class' => 'setrun\backend\over\grid\ActionColumn',
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

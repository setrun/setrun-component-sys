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
LanguageAsset::register($this, [
    'js/language/index.js'
]);
?>
<div class="language-index">
    <div class="box">
        <div class="box-body">
            <p>
                <a href="<?= Url::to(['create']) ?>" class="btn btn-success">
                    <i class="fa fa-fw fa-plus"></i> <?= Yii::t('setrun/sys/language', 'Create Language') ?>
                </a>
                <a href="javascript:void(0)" class="btn btn-info" id="clear-filter">
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

                    'status' => [
                        'attribute' => 'status',
                        'filter'    => Language::getStatuses(),
                        'filterInputOptions' => [
                            'prompt'  => '&nbsp;',
                            'encode'  => false
                        ],
                        'format'    => 'raw',
                        'value'     => function($model, $index, $key){
                            $checked = (int)$model->status === 1 ? 'checked' : '';
                            $html    = "<input type=\"checkbox\" class=\"switcher switcher_status\" {$checked} data-id=\"{$model->id}\" data-url=\"" . Url::to(['status', 'id' => $model->id]) ."\"  id=\"switcher_status_{$model->id}\" />";
                            $html   .= "<label class='switcher_label' for=\"switcher_status_{$model->id}\"></label>";
                            return $html;
                        },
                    ],
                    'is_default' => [
                        'attribute'=> 'is_default',
                        'format'    => 'raw',
                        'value'     => function($model, $index, $key){
                            $checked = $model->is_default == 1 ? 'checked' : '';
                            $html    = "<input type=\"checkbox\" 
                                               class=\"switcher switcher_default\" {$checked} 
                                               data-id=\"{$model->id}\" 
                                               data-url=\"" . Url::to(['default', 'id' => $model->id]) ."\" 
                                               data-confirm-message=\"" . Yii::t('setrun/sys/language', 'Do you want to set the default language ?') ."\" 
                                               id=\"switcher_default_{$model->id}\" 
                                        />";
                            $html   .= "<label class='switcher_label' for=\"switcher_default_{$model->id}\"></label>";
                            return $html;
                        },
                    ],
                    [
                        'class' => 'setrun\backend\over\grid\ActionColumn',
                        'template' =>'{sort} {edit} {view}  {delete}',
                        'buttons'  =>[
                            'sort' => function ($url, $model, $key) {
                                return '<div class="sortable-widget-handler btn btn-xs btn-default" data-id="'.$model->id.'">☰</div>';
                            },

                        ],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>

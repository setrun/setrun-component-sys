<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use kartik\icons\Icon;
use yii\grid\GridView;
use kartik\editable\Editable;
use kartik\daterange\DateRangePicker;
use kotchuprik\sortable\assets\SortableAsset;
use setrun\sys\entities\manage\Language;

/* @var $this         yii\web\View */
/* @var $searchModel  setrun\sys\forms\backend\search\LanguageSearchForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('setrun/sys/language', 'Languages');
$this->params['breadcrumbs'][] = $this->title;

Icon::map($this, Icon::FI);
?>
<div class="language-index">
    <div class="box">
        <div class="box-body">
            <p>
                <a href="<?= Url::to(['create']) ?>" class="btn btn-success">
                    <i class="fa fa-fw fa-plus"></i> <?= Yii::t('setrun/sys/language', 'Create Language') ?>
                </a>
            </p>
            <hr />
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
                    'icon_id' => [
                        'attribute' => 'icon_id',
                        'label' => '',
                        'format'    => 'raw',
                        'value'     => function($model, $index, $key){
                            return Icon::show($model->icon_id, [], Icon::FI);
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
                        'format'    => 'raw',
                        'value'     => function($model, $index, $key){
                            $checked = (int)$model->status === 1 ? 'checked' : '';
                            $html    = "<input type=\"checkbox\" class=\"switcher switcher_default\" {$checked} data-id=\"{$model->id}\" id=\"switcher_status_{$model->id}\" />";
                            $html   .= "<label class='switcher_label' for=\"switcher_status_{$model->id}\"></label>";
                            return $html;
                        },
                    ],
                    'bydefault' => [
                        'attribute'=> 'bydefault',
                        'format'    => 'raw',
                        'value'     => function($model, $index, $key){
                            $checked = (int)$model->bydefault === 1 ? 'checked' : '';
                            $html    = "<input type=\"checkbox\" class=\"switcher switcher_default\" {$checked} data-id=\"{$model->id}\" id=\"switcher_default_{$model->id}\" />";
                            $html   .= "<label class='switcher_label' for=\"switcher_default_{$model->id}\"></label>";
                            return $html;
                        },
                    ],
                    [
                        'class' => 'setrun\backend\components\grid\ActionColumn'
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

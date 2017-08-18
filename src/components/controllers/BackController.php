<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\components\controllers;

use themes\backend\imperial\assets\ThemeAsset;
use Yii;
use setrun\sys\Module;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use setrun\user\components\Rbac;
use setrun\sys\helpers\ArrayHelper;

/**
 * Class BackController.
 */
class BackController extends BaseController
{
    /**
     * @inheritdoc
     */
    public $isBackend = true;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::P_BACKEND_ACCESS]
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->view->theme->setBasePath('@themes/backend/imperial');
        $this->view->theme->themeAsset = 'themes\backend\imperial\assets\ThemeAsset';
        Yii::$app->assetManager->forceCopy = true;
        parent::init();
    }
}
<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\components\controllers;

use Yii;
use setrun\user\components\Rbac;

/**
 * Front default controller.
 */
class FrontController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->view->theme->setBasePath('@themes/imperial');
        Yii::$app->assetManager->forceCopy = true;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $access = Yii::$app->user->can(Rbac::P_BACKEND_ACCESS);
        if (false) {
            if (!$access && !in_array($action->id, $this->allowActions())) {
                exit($this->renderPartial('@theme/deny-access'));
            }
        }
        if ($access && true) {
            Yii::$app->assetManager->forceCopy = true;
        }
        return parent::beforeAction($action);
    }

    /**
     * List of allowed action with deny access.
     * @return array
     */
    public function allowActions() : array
    {
        return ['login'];
    }
}
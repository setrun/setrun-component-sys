<?php

namespace setrun\sys\controllers\backend;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use setrun\sys\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use setrun\sys\helpers\ErrorHelper;
use yii\base\InvalidConfigException;
use setrun\sys\exceptions\YiiException;
use kotchuprik\sortable\actions\Sorting;
use setrun\sys\services\LanguageService;
use setrun\sys\entities\manage\Language;
use setrun\sys\forms\backend\LanguageForm;
use setrun\sys\components\controllers\BackController;
use setrun\sys\forms\backend\search\LanguageSearchForm;

/**
 * LanguageController implements the CRUD actions for Language model.
 */
class LanguageController extends BackController
{
    /**
     * @var LanguageService
     */
    protected $service;

    /**
     * LanguageController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param LanguageService $service
     * @param array $config
     */
    public function __construct($id, $module, LanguageService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);

    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge([
            'sorting' => [
                'class'          => Sorting::className(),
                'orderAttribute' => 'position',
                'query'          => Language::find()
            ]
        ], parent::actions());
    }

    /**
     * Lists all Language models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new LanguageSearchForm();
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $searchModel->search(),
        ]);
    }

    /**
     * Displays a single Language model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Language model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new LanguageForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model = $this->service->create($form);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Edites an existing Language model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $form  = new LanguageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())){
            $errors = ActiveForm::validate($form);
            if (!$errors) {
                try {
                    $this->service->edit($form->id, $form);
                    $this->output['status'] = 1;
                } catch (YiiException $e) {
                    $errors = ErrorHelper::checkModel($e->data, $form);
                }
            }
            $this->output['errors'] = $errors; return;
        }
        return $this->render('edit', ['model' => $form]);
    }

    /**
     * Deletes an existing Language model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->service->remove($id);
                $this->output['status'] = 1;
            } catch (YiiException $e) {
                $this->output['errors'] = (array)$e->data;
            }
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDefault($id)
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->service->default($id);
                $this->output['status'] = 1;
            } catch (YiiException $e) {
                $this->output['errors'] = (array)$e->data;
            }
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionStatus($id)
    {
        if (Yii::$app->request->isAjax) {
            try {
                $this->service->status($id, Yii::$app->request->post('status'));
                $this->output['status'] = 1;
            } catch (YiiException $e) {
                $this->output['errors'] = (array)$e->data;
            }
        }
    }

    /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Language the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Language::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

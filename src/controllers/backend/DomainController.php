<?php

namespace setrun\sys\controllers\backend;

use Yii;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use setrun\sys\helpers\ErrorHelper;
use setrun\sys\services\DomainService;
use setrun\sys\entities\manage\Domain;
use setrun\sys\forms\backend\DomainForm;
use setrun\sys\forms\backend\search\DomainSearchForm;
use setrun\sys\components\controllers\BackController;


/**
 * DomainController implements the CRUD actions for Domain model.
 */
class DomainController extends BackController
{
    /**
     * @var DomainService
     */
    protected $service;

    /**
     * DomainController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param DomainService $service
     * @param array $config
     */
    public function __construct($id, $module, DomainService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * Lists all Domain models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new DomainSearchForm();
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $searchModel->search(),
        ]);
    }

    /**
     * Displays a single Domain model.
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
     * Creates a new Domain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DomainForm();
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
     * Edites an existing Domain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        $form  = new DomainForm($model);
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
     * Deletes an existing Domain model.
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
                $this->output['errors'] = (array) $e->data;
            }
        }
    }

    /**
     * Finds the Domain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Domain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Domain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

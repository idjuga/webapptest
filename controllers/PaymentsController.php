<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Payments;
use app\models\Clients;
use app\models\PaymentsToClients;

/**
 * PaymentsController
 */
class PaymentsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if ($this->isUserAuthor()) {
                                return true;
                            }
                            return false;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Payments
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Payments::find()->onlyOwn(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment
     * @param integer $id
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Payments model
     */
    public function actionCreate()
    {
        $model = new Payments();
        $requestData = Yii::$app->request->post();
        if ($model->load($requestData) && $model->save()) {
            if (!empty($requestData['Payments']['clients'])) {
                $model->linkPaymentsToClients($requestData['Payments']['clients']);
            }
            return $this->redirect(['index']);
        }
        $clients = Clients::find()->onlyOwn()->asArray()->all();
        return $this->render('create', [
            'model' => $model,
            'clients' => $clients,
        ]);
    }

    /**
     * Updates an existing Payments model
     * @param integer $id
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $requestData = Yii::$app->request->post();
        if ($model->load($requestData) && $model->save()) {
            if (!empty($requestData['Payments']['clients'])) {
                $model->linkPaymentsToClients($requestData['Payments']['clients']);
            }
            return $this->redirect(['index']);
        }
        $clients = Clients::find()->onlyOwn()->asArray()->all();
        return $this->render('update', [
            'model' => $model,
            'clients' => $clients,
        ]);
    }

    /**
     * Deletes an existing Payments model
     * @param integer $id
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payments model based on its primary key value
     * @param integer $id
     */
    protected function findModel($id)
    {
        if (($model = Payments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function isUserAuthor()
    {
        return $this->findModel(Yii::$app->request->get('id'))->user_id->id == Yii::$app->user->id;
    }
}

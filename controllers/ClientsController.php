<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Clients;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Country;
use app\models\Payments;

/**
 * ClientsController
 */
class ClientsController extends Controller
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
     * Lists all Clients
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Clients::find()->onlyOwn(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client
     * @param integer $id
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Client
     */
    public function actionCreate()
    {
        $model = new Clients();

        $requestData = Yii::$app->request->post();
        if ($model->load($requestData) && $model->save()) {
            if (!empty($requestData['Clients']['payments'])) {
                $model->linkPaymentsToClients($requestData['Clients']['payments']);
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'countriesList' => Country::getCoutriesList(),
            'payments' => Payments::find()->onlyOwn()->asArray()->all(),
        ]);
    }

    /**
     * Update Client
     * @param integer $id
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $requestData = Yii::$app->request->post();
        if ($model->load($requestData) && $model->save()) {
            if (!empty($requestData['Clients']['payments'])) {
                $model->linkPaymentsToClients($requestData['Clients']['payments']);
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'countriesList' => Country::getCoutriesList(),
            'payments' => Payments::find()->onlyOwn()->asArray()->all(),
        ]);
    }

    /**
     * Deletes Client
     * @param integer $id
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Client based on its primary key value
     * @param integer $id
     */
    protected function findModel($id)
    {
        if (($model = Clients::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function isUserAuthor()
    {
        return $this->findModel(Yii::$app->request->get('id'))->user_id->id == Yii::$app->user->id;
    }
}

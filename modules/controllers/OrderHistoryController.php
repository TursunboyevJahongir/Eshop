<?php


namespace app\modules\controllers;


use app\models\OrderHistory;
use app\models\ResponseJSON;
use http\Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class OrderHistoryController extends Controller
{
    public function beforeAction($action)
    {

        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'create' => ['post'],
                    'update' => ['put', 'patch'],
                    'delete' => ['delete']
                ]
            ]
        ];
    }

    public function actionIndex($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        if ($id !== null) {
            if (!is_numeric($id))
                throw new NotFoundHttpException('topilmadi');
            try {
                $result = [];
                $order = OrderHistory::findOne(['id' => $id]);
                if ($order === null) {
                    throw new NotFoundHttpException('topilmadi');
                }
                $add = $order->toArray();
                $add = array_merge($add,[
                    'user' => $order->user,
                    'region' => $order->region,
                    'address' => $order->address,
                ]);
                array_push($result, $add);

                $response->status = 'ok';
                $response->data = $result;
                $response->message = '';
                return $response;
            } catch (Exception $e) {
                $response->status = 'error';
                $response->message = $e->getMessage();
                return $response;
            }
        }
        else{
            try {
                $model = OrderHistory::find()->all();
                $response->status = 'ok';
                $response->data = $model;
                $response->message = '';
                return $response;
            } catch (Exception $e) {
                $response->status = 'error';
                $response->message = $e->getMessage();
                return $response;
            }
        }
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        $model = new OrderHistory();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            $model->save();
            $response->status = 'ok';
            $response->message = "";
            $response->data = "";
            return $response;
        } else
            return ['status' => 'error', 'message' => $model->getErrors(), 'data'=>""];
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        if ($id !== null && is_numeric($id)) {
            $model = OrderHistory::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('topilmadi');
            }
            if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
                $model->save();
                $response->status="ok";
                $response->message = "";
                $response->data = "";
                return $response;
            } else
                return ['status' => 'error', 'message' => $model->getErrors(),'data' => ""];
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = OrderHistory::findOne(['id' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException('topilmadi');
        }
        if ($id !== null) {
            $deleted = $model->delete();
            return $deleted !== false ? ['status' => 'deleted'] : ['status' => 'error'];
        } else {
            return ['status' => 'error','message' => $model->getErrors(),'data' => ""];
        }
    }

}
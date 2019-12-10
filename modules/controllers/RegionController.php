<?php


namespace app\modules\controllers;


use app\models\Region;
use app\models\ResponseJSON;
use http\Exception;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RegionController extends Controller
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
        if($id == null)
        {
            try {
                $model = Region::find()->all();
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
        else
        {
            try {
                $model = Region::findOne(['id' => $id]);
                if ($model === null) {
                    throw new NotFoundHttpException('topilmadi');
                }
                $res = $model->toArray();
                $dis = ['districts' => $model->districts];
                $res = array_merge($res, $dis);
                $response->status = 'ok';
                $response->data = $res;
                $response->message = '';
                return $response;
            } catch (Exception $e) {
                $response->status = 'error';
                $response->data = "";
                $response->message = $e->getMessage();
                return $response;
            }
        }
    }

    /**
     * @return ResponseJSON|array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        $model = new Region();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            $model->save();
            $response->status = 'ok';
            $response->message = "";
            $response->data = "";
            return $response;
        } else
            return ['status' => 'error', 'message' => $model->getErrors(), 'data' => ""];
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        if ($id !== null && is_numeric($id)) {
            $model = Region::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('topilmadi');
            }
            if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
                $model->save();
                $response->status = "ok";
                $response->message = "";
                $response->data = "";
                return $response;
            } else
                return ['status' => 'error', 'message' => $model->getErrors(), 'data' => ""];
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Region::findOne(['id' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException('topilmadi');
        }
        if ($id !== null) {
            $deleted = $model->delete();
            return $deleted !== false ? ['status' => 'deleted'] : ['status' => 'error'];
        } else {
            return ['status' => 'error', 'message' => $model->getErrors(), 'data' => ""];
        }
    }
}
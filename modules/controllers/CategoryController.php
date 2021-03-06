<?php


namespace app\modules\controllers;


use app\models\Category;
use app\models\ResponseJSON;
use http\Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CategoryController extends Controller
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
                'class' => VerbFilter::class,
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
        if($id !== null)
        {
            try {
                if (!is_numeric($id))
                    throw new NotFoundHttpException('topilmadi');
                $model = Category::findOne(['id' => $id])->toArray();
                $child = ['categories' => Category::findAll(['parent_id' => $id])];
                $result = array_merge($model, $child);
                $response->status = 'ok';
                $response->message = '';
                $response->data = $result;
                return $response;
            }
            catch (Exception $e) {
                $response->status = 'error';
                $response->message = $e->getMessage();
                return $response;
            }
        }
        else
            {
                try {
                    $model = Category::find()->all();
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

    public function actionCategoryIerarchy()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        $result = [];
        try {
            $model = Category::find()->all();
            foreach ($model as $key => $c) {
//                $b = $c->toArray();
//                $b = array_merge($b,[
//                    '' => $c->district->name,
//                    'region_name' => $c->district->region->name,
//                    'region' => $c->district->region,
//                    'district' => $c->district
//                ]);
            $child = ['child' => Category::findAll(['parent_id' => $key])];
                array_push($result, $child);
            }

            $response->status = 'ok';
            $response->message = '';
            $response->data = $result;
            return $response;
        } catch (Exception $e) {
            $response->status = 'error';
            $response->message = $e->getMessage();
            return $response;
        }
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        $model = new Category();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            $model->save();
            $response->status = 'ok';
            $response->message = null;
            return $response;
        } else
            return ['status' => 'error', 'message' => $model->getErrors(), 'data'=>""];
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        if ($id !== null && is_numeric($id)) {
            $model = Category::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('topilmadi');
            }
            if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
                $model->save();
                $response->status="ok";
                $response->message = null;
                return $response;
            } else
                return ['status' => 'error', 'message' => $model->getErrors(),'data' => ""];
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Category::findOne(['id' => $id]);
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
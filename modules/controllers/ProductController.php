<?php


namespace app\modules\controllers;


use app\models\Product;
use app\models\ResponseJSON;
use http\Exception;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProductController extends Controller
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
        if($id !==null ) {
            if (!is_numeric($id))
                throw new NotFoundHttpException('topilmadi');
            try {
                $result = [];
                $product = Product::findOne(['id' => $id]);
                if ($product === null) {
                    throw new NotFoundHttpException('topilmadi');
                }
                $add = $product->toArray();
                $add = array_merge($add,[

                    'region'=>$product->district->region->name,
                    'district' => $product->district->name,
                    'category' => $product->category,
                    'shop' => $product->shop,
                    'manufacture' => $product->manufacture,
                    'image' => $product->images
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
        else
        {
            try {
                $model = Product::find()->all();
                $image = [];
                foreach ($model as $item):
                    $result = ['image' => $item->images];
                    array_push($image,$result);
                    endforeach;
                $response->data = array_merge($model,$image);
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
        $model = new Product();
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
            $model = Product::findOne(['id' => $id]);
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
        $model = Product::findOne(['id' => $id]);
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
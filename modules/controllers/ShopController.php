<?php

namespace app\modules\Controllers;

use app\models\ResponseJSON;
use app\models\Shop;
use http\Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ShopController extends Controller
{
    public function actionIndex($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        if ($id == null) {
            try {
                $model = Shop::find()->all();
                $response->status = 'ok';
                $response->data = $model;
                $response->message = '';
                return $response;
            } catch (Exception $e) {
                $response->status = 'error';
                $response->message = $e->getMessage();
                return $response;
            }
        } elseif ($id !== null) {
            if (!is_numeric($id))
                throw new NotFoundHttpException('topilmadi');
            try {
                $model = Shop::findOne(['id' => $id]);
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

//    public function actionCreate()
//    {
//        return $this->render('create');
//    }
//
//    public function actionDelete()
//    {
//        return $this->render('delete');
//    }
//
//
//
//    public function actionUpdate()
//    {
//        return $this->render('update');
//    }

}

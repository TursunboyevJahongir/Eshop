<?php
/**
 * Created by PhpStorm.
 * User: Jahongir
 * Date: 23.09.2019
 * Time: 18:54
 */

namespace app\controllers;


use app\models\AddressModel;
use app\models\ResponseJSON;
use app\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Exception;
use yii\db\Query;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller
{
    public $modelClass = 'app\models\User';

    public function beforeAction($action)
    {

        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionGet($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($id == null) {
            $model = User::find()->all();
            $response = new ResponseJSON();
            $response->status = 'ok';
            $response->data = $model;
            return $response;
        }
        else
        {
            if ($id !== null && is_numeric($id)) {
                $model = User::findOne(['id' => $id]);
                if ($model === null) {
                    throw new NotFoundHttpException('topilmadi');
                }
//                $address = Yii::$app->db->createCommand("SELECT region.name AS Region,district.name AS District,address.address AS Address FROM address LEFT JOIN district district ON district.id = address.`district_id` LEFT JOIN region region ON region.id = district.`region_id`")->queryAll();
                $query = new Query;
                $query = $query->select(" region.name AS Region,district.name AS District,address.address AS Address ")
                    ->from('address')
                    ->Leftjoin("district",' district.id = address.`district_id`')
                    ->Leftjoin("region",' region.id = district.`region_id`')->all();
                $query =['address'=> $query];
                $model = $model->toArray();
                $res = array_merge($model,$query);

                return $res;
            }
        }
    }


    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;


        $model = new User();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            $model->save();
            return ['status' => 'ok'];
        } else
            return ['status' => 'error', 'message' => $model->getErrors()];
    }

    public function actionUpdate($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($id !== null && is_numeric($id)) {
            $model = User::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('topilmadi');
            }
            if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
                $model->save();
                return ['status' => 'ok'];
            } else
                return ['status' => 'error', 'message' => $model->getErrors()];
        }
    }

    /**
     * @param $id
     * @return array
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if (Yii::$app->request->isDelete) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = User::findOne(['id' => $id]);
            if ($id !== null) {
                $deleted = $model->delete();
                return $deleted !== false ? ['status' => 'deleted'] : ['status' => 'error'];
            } else {
                return ['status' => 'error'];
            }
        }

    }


}
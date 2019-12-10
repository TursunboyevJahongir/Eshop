<?php


namespace app\controllers;


use app\models\ResponseJSON;
use http\Exception;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class crud
{
    public function beforeAction($action)
    {

        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @param $table
     * @param null $name
     * @param null $id
     * @return ResponseJSON
     * @throws NotFoundHttpException
     */
    public function Get($table,$name=null,$id = null)
    {
        var_dump($name);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        $t = "app\\models\\".$table;
        if($id == null AND $name == null)
        {
            try {
                $model = $t::find()->all();
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
        elseif ($id !==null && $name == null)
        {
            if(!is_numeric($id))
                throw new NotFoundHttpException('topilmadi');
            try {
                $model = $t::findOne(['id' => $id]);
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
        elseif ($id ==null && $name !== null)
        {
            try {
                $model = $t::findOne(['name' => $name]);
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

    /**
     * @param string $table
     * @return ResponseJSON|array
     * @throws \yii\base\InvalidConfigException
     */
    public function Create($table)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        $t = "app\\models\\".$table;
        $model = new $t();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            $model->save();
            $response->status = 'ok';
            $response->message = null;
            return $response;
        } else
            return ['status' => 'error', 'message' => $model->getErrors(), 'data'=>null];
    }

    /**
     * @param string $table
     * @param integer $id
     * @return ResponseJSON|array
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function Update($table,$id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        if ($id !== null && is_numeric($id)) {
            $t = "app\\models\\".$table;
            $model = $t::findOne(['id' => $id]);
            if ($model === null) {
                throw new NotFoundHttpException('topilmadi');
            }
            if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
                $model->save();
                $response->status="ok";
                $response->message = null;
                return $response;
            } else
                return ['status' => 'error', 'message' => $model->getErrors(),'data' => null];
        }
    }

    /**
     * @param $table
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function Delete($table,$id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $t = "app\\models\\".$table;
        $model = $t::findOne(['id' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException('topilmadi');
        }
        if ($id !== null) {
            $deleted = $model->delete();
            return $deleted !== false ? ['status' => 'deleted'] : ['status' => 'error'];
        } else {
            return ['status' => 'error'];
        }
    }
}
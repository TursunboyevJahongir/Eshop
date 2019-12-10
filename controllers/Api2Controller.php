<?php
namespace app\controllers;
use app\Controllers;
use app\models\Address;
use app\models\Category;
use app\models\District;
use app\models\Manufacture;
use app\models\Region;
use app\models\ResponseJSON;
use app\models\Shop;
use http\Exception;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\controllers\crud as crudAlias;

class Api2Controller extends Controller
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
//        var_dump($name);
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
            return ['status' => 'error', 'message' => $model->getErrors(), 'data'=>""];
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
                return ['status' => 'error', 'message' => $model->getErrors(),'data' => ""];
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
            return ['status' => 'error','message' => $model->getErrors(),'data' => ""];
        }
    }

    public function actionAddress()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $model = Yii::$app->db->createCommand("SELECT region.name AS Region,district.name AS District,address.address AS Address FROM address LEFT JOIN district district ON district.id = address.`district_id` LEFT JOIN region region ON region.id = district.`region_id`")->queryAll();
        $query = new Query;
        $query->select("region.name AS Region,district.name AS District,address.address AS Address")
            ->from('address')
            ->Leftjoin("district",' district.id = address.`district_id`')
            ->Leftjoin("region",' region.id = district.`region_id`');
// build and execute the query
        $model = $query->all();

//        $model = Address::find()->all();
        $response = new ResponseJSON();
        $response->status = 'ok';
        $response->message = '';
        $response->data = $model;

        return $response;
    }

    public function actionAddressCreate()
    {
        $model = $this->Create();
        return $model;
    }

    public function actionAddressUpdate($id)
    {
        $model = $this->Update('Address',$id);
        return $model;
    }

    public function actionAddressDelete($id)
    {
        $model = $this->Delete('Address',$id);
        return $model;
    }

    /**
     * @param null $id
     * @return ResponseJSON
     */
    public function actionRegion($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();

        if ($id == null) {
            $model = $this->Get('Region');
            return  $model;
        }
        else {
            try {
                $model = Region::findOne(['id' => $id]);
                $res = $model->toArray();
                $dis = ['districts' => $model->districts];
                $res = array_merge($res, $dis);
                $response->status = 'ok';
                $response->data = $res;
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
     * @param null $id
     * @return ResponseJSON
     */
    public function actionDistrict($id = null)
    {
        if($id == null)
        {
            $model = $this->Get('District');
            return  $model;
        }
        else
        {
            try {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
                $model = District::findOne(['id' => $id]);
                $res = $model->toArray();
                $dis = ['region' => $model->region];
                $res = array_merge($res , $dis);
                $response->status = 'ok';
                $response->data = $res;
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
     * @param number $id
     * @param null $name
     * @return ResponseJSON
     */
    public function actionManufacture($id= null,$name =null)
    {
        $model = $this->Get('Manufacture',$name,$id);
        return $model;
    }

    public function actionManufactureCreate(){
        $model = $this->Create('Manufacture');
        return $model;
    }

    public function actionManufactureUpdate($id)
    {
        $model = $this->Update('Manufacture',$id);
        return $model;
    }

    public function actionManufactureDelete($id)
    {
        $model = $this->Delete('Manufacture',$id);
        return $model;
    }
    public function actionShop($id= null,$name =null)
    {
        $model = $this->Get('Shop',$name,$id);
        return $model;
    }

    public function actionShopCreate(){
        $model = $this->Create();
    }

    public function actionShopUpdate($id)
    {
        $model = $this->Update('Shop',$id);
        return $model;
    }

    public function actionShopDelete($id)
    {
        $model = $this->Delete('Shop',$id);
        return $model;
    }

    public function actionCategory($name = null, $id = null, $parent_id=null)
    {

        if($parent_id !==null)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response = new ResponseJSON();
            if(!is_numeric($parent_id))
                throw new NotFoundHttpException('topilmadi');
            try {
                $model = Category::findAll(['parent_id' => $parent_id]);
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
                $model = $this->Get('Category',$name,$id);
                return $model;
            }
    }

    public function actionCategoryCreate()
    {
        $model = $this->Create();
        return $model;
    }

    public function actionCategoryUpdate($id)
    {
        $model = $this->Update('Category',$id);
        return $model;
    }

    public function actionCategoryDelete($id)
    {
        $model = $this->Delete('Category',$id);
        return $model;
    }

    public function actionProduct($id=null){
        if($id == null) {
            $model = $this->Get('Product');
            return $model;
            }
    }

    public function actionFavourite()
    {
        $model = $this->Get('Favourite');
        return $model;
    }

    public function actionFavouriteCreate()
    {
        $model = $this->Create('Favourite');
        return $model;
    }

}
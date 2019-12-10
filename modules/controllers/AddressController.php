<?php


namespace app\modules\controllers;


use app\models\Address;
use app\models\ResponseJSON;
use http\Exception;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AddressController extends Controller
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

        if($id == null)
        {
//            try {
//                $model = Yii::$app->db->createCommand("SELECT region.name AS Region,district.name AS District,address.address AS Address FROM address LEFT JOIN district district ON district.id = address.`district_id` LEFT JOIN region region ON region.id = district.`region_id`")->queryAll();
//            } catch (Exception $e) {
//            }

//            $query = new Query;
//            $query->select("address.id ,region.name AS region_name,district.name AS district_name,address.name AS name")
//                ->from('address')
//                ->Leftjoin("district",' district.id = address.`district_id`')
//                ->Leftjoin("region",' region.id = district.`region_id`');
            $result = [];
            $address = Address::find()->all();
//            foreach ($address as $ad) {
//                $b = $ad->toArray();
//                $b = array_merge($b,[
//                    'district_name' => $ad->district->name,
//                    'region_name' => $ad->district->region->name,
//                    'region' => $ad->district->region,
//                    'district' => $ad->district
//                ]);
//                array_push($result, $b);
//            }
            $response->status = 'ok';
            $response->message = '';
            $response->data = $address;
            return $response;
        }
        else
        {
            if (!is_numeric($id))
                throw new NotFoundHttpException('topilmadi');
            try {
                $result = [];
                $address = Address::findOne(['id' => $id]);
                $add = $address->toArray();
                    $add = array_merge($add,[
                        'district_name' => $address->district->name,
                        'region_name' => $address->district->region->name,
                        'region' => $address->district->region,
                        'district' => $address->district
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

    }

    /**
     * @return ResponseJSON|array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = new ResponseJSON();
        $model = new Address();
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
            $model = Address::findOne(['id' => $id]);
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
        $model = Address::findOne(['id' => $id]);
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
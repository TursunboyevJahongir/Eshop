<?php


namespace app\modules\controllers;


use app\models\ResponseJSON;
use app\models\UploadForm;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class UserController extends Controller
{
    public $modelClass = 'app\models\User';

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
                $query = $query->select(" region.name AS region,district.name AS district,address.name AS name ")
                    ->from('address')
                    ->Leftjoin("district",' district.id = address.`district_id`')
                    ->Leftjoin("region",' region.id = district.`region_id`')
                    ->where('address.id ='.$model->address_id)->all();
                $query =['Address'=> $query];
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
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {

            $imgmodel = new UploadForm();


                $imgmodel->img = UploadedFile::getInstance($imgmodel, 'img');

                    $img = $imgmodel->upload();
                    if ($img === false) {
                        throw new Exception('Upload failed');
                    }
                    Image::thumbnail($_SERVER['DOCUMENT_ROOT'].'/web/'.$img['path'].$img['name'], 256, 256, 0)->save($_SERVER['DOCUMENT_ROOT'].'/web/'.$img['path'].'256_'.$img['name'], ['jpeg_quality' => 50]);
                    $model->image = $img['path'].'256_'.$img['name'];


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

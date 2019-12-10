<?php

namespace app\modules\Admin\controllers;

use app\controllers\BaseController;
use app\models\Category;
use app\models\District;
use app\models\Manufacture;
use app\models\Region;
use app\models\Shop;
use app\models\UploadForm;
use Yii;
use app\models\product;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PraductController implements the CRUD actions for product model.
 */
class ProductController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $query = \app\models\Image::find()->where(['product_id'=>$id]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize'=>9]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $images = \app\models\Image::findAll(['product_id'=>$id]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'images' => $models,
            'pagination' => $pages,
        ]);
    }

    /**
     * Creates a new product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new product();
        $region = Region::find()->all();
        $district = District::find()->all();
        $category = Category::find()->asArray()->all();
        $shop = Shop::find()->all();
        $manufacture = Manufacture::find()->all();
        $imgmodel = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            var_dump($imgmodel);
//            die;
//            return $this->redirect(['view', 'id' => $model->id]);
            $model->save();
            $imgmodel = UploadedFile::getInstances($imgmodel, 'img');
            if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
                $index=null;
                foreach ($imgmodel as $image):
                    $img['path'] = '/uploads/products/';
                    $img['name'] = time().uniqid().'.'.$image->getExtension();
                    $image->saveAs($_SERVER['DOCUMENT_ROOT'].'/web'.$img['path'].$img['name']);
//var_dump(Image::thumbnail($_SERVER['DOCUMENT_ROOT'] . '/web' . $img['path'] . $img['name'], 1024, 1024, 0)->save($_SERVER['DOCUMENT_ROOT'] . '/web/' . $img['path'] . '1024_' . $img['name']));
//die;
                    $thumb = new \app\models\Image();
//                    $thumb->path = $this->Thumb($img['name']);
                    $thumb->path = $img['path'] . $img['name'];
//                    $thumb->thumb_1024 = Image::thumbnail($_SERVER['DOCUMENT_ROOT'] . '/web' . $img['path'] . $img['name'], 1024, 1024, 0)->save($_SERVER['DOCUMENT_ROOT'] . '/web/' . $img['path'] . '1024_' . $img['name']);
                    $thumb->thumb_1024 = $this->Thumb($img['name'],1024,'/uploads/products/');
//                    $thumb->thumb_256 = Image::thumbnail($_SERVER['DOCUMENT_ROOT'] . '/web' . $img['path'] . $img['name'], 256, 256, 0)->save($_SERVER['DOCUMENT_ROOT'] . '/web/' . $img['path'] . '256_' . $img['name'], ['jpeg_quality' => 50]);
                    $thumb->thumb_256 =  $this->Thumb($img['name'],256,'/uploads/products/');
                    $thumb->product_id = $model->id;
                    $thumb->save();
                    if(is_null($index)){
                        $index=$thumb->id;
                    }
                endforeach;

            }
            $model->defoult_image =$index;
            $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'region' => $region,
            'district' => $district,
            'category' => $category,
            'shop' => $shop,
            'manufacture' => $manufacture,
            'imgmodel' => $imgmodel,
        ]);
    }

    /**
     * Updates an existing product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionA() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = District::find()->andWhere(['region_id' => $id])->asArray()->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $district) {
                    $out[] = ['id' => $district['id'], 'name' => $district['name']];
                    if ($i == 0) {
                        $selected = $district['id'];
                    }
                }
                // Shows how you can preselect a value
                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
}

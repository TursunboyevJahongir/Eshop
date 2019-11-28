<?php

namespace app\modules\Admin\controllers;

use app\models\Region;
use app\models\UploadForm;
use Yii;
use app\models\User;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpload()
    {
        $model = new UploadForm();
        $img = '';
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate())  {
            $img = $model->upload();
            if ($img === false) {
                throw new Exception('Upload failed');
            }

            Image::thumbnail($img['path'].$img['name'], 128, 128, 0)->save($_SERVER['DOCUMENT_ROOT'].'/web/'.$img['path'].'128_'.$img['name'], ['jpeg_quality' => 50]);
        }

        return $this->render('upload', ['model' => $model, 'i' => $_SERVER['DOCUMENT_ROOT'].'/web/'.$img['path'].'128_'.$img['name']]);
    }
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $region = Region::find()->select('id,name')->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            var_dump($region);
//            foreach ($region as $r):
//                echo $r->name.'<br>';
//            endforeach;
//            $model->img = UploadedFile::getInstance($model, 'img');
//            $model->img->saveAs('uploads/' . $model->img->baseName . '.' . $model->img->extension);
//            $model->image = 'uploads/' . $model->img->baseName . '.' . $model->img->extension;
//            $model->save();
//            return $this->redirect(['view', 'id' => $model->id]);
            $imgmodel = new UploadForm();

            if (Yii::$app->request->isPost) {
                $imgmodel->img = UploadedFile::getInstance($imgmodel, 'img');
                if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate())  {
                    $img = $imgmodel->upload();
                    if ($img === false) {
                        throw new Exception('Upload failed');
                    }
                    Image::thumbnail($_SERVER['DOCUMENT_ROOT'].'/web/'.$img['path'].$img['name'], 256, 256, 0)->save($_SERVER['DOCUMENT_ROOT'].'/web/'.$img['path'].'256_'.$img['name'], ['jpeg_quality' => 50]);
                    $model->image = $img['path'].'256_'.$img['name'];
                }
            }
            $model->save();

                return $this->redirect(['view', 'id' => $model->id]);
//            return $this->render('create', ['model' => $model, 'imgmodel' => $imgmodel]);
        }
        $imgmodel = new UploadForm();
        return $this->render('create', [
            'model' => $model,
            'region' => $region,
            'imgmodel' => $imgmodel
        ]);
    }

    /**
     * Updates an existing User model.
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

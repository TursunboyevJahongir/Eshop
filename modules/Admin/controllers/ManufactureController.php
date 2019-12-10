<?php

namespace app\modules\Admin\controllers;

use app\controllers\BaseController;
use app\models\UploadForm;
use Yii;
use app\models\Manufacture;
use yii\base\Exception;
use yii\base\Theme;
use yii\data\ActiveDataProvider;
use yii\imagine\Image;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ManufactureController implements the CRUD actions for Manufacture model.
 */
class ManufactureController extends BaseController
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
     * Lists all Manufacture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Manufacture::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Manufacture model.
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

    /**
     * Creates a new Manufacture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Manufacture();
        $imgmodel = new UploadForm();
        $imgpath = '/uploads/manufacturers/';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            if (Yii::$app->request->isPost) {
                if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
                    $imgmodel= UploadedFile::getInstances($imgmodel, 'img');
                    $name = $model->id . '.png';
                    $imgmodel[0]->saveAs($_SERVER['DOCUMENT_ROOT'] . '/web' . $imgpath . $name);
                    $images = $this->Thumb($name, 128, $imgpath);
                    $model->ico = $imgpath. '128_' . $name;
                    @unlink($_SERVER['DOCUMENT_ROOT'] . '/web/' . $imgpath . $name);
                }
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'imgmodel' => $imgmodel
        ]);
    }

    /**
     * Updates an existing Manufacture model.
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
     * Deletes an existing Manufacture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        @unlink($_SERVER['DOCUMENT_ROOT'] . '/web/' . $this->findModel($id)->ico);
        $this->findModel($id)->delete();


        return $this->redirect(['index']);
    }

    /**
     * Finds the Manufacture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Manufacture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manufacture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

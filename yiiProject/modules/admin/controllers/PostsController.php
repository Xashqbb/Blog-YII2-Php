<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\Posts;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\ImageUpload;

class PostsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Posts::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Posts();
        $imageUpload = new ImageUpload();

        if ($model->load(Yii::$app->request->post())) {
            $imageUpload->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($imageUpload->upload($model->id)) {
                $model->image = $imageUpload->getUploadedFilePath();
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Post created successfully!');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to create the post.');
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            // Якщо завантажено нове зображення
            if ($model->imageFile) {
                $imagePath = 'uploads/images/' . Yii::$app->security->generateRandomString(10) . '.' . $model->imageFile->extension;

                // Стерти старе зображення, якщо воно існує
                if ($model->image && file_exists(Yii::getAlias('@webroot') . $model->image)) {
                    unlink(Yii::getAlias('@webroot') . $model->image);
                }

                // Зберегти нове зображення
                if ($model->imageFile->saveAs(Yii::getAlias('@webroot') . '/' . $imagePath)) {
                    $model->image = '/' . $imagePath;
                }
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Post updated successfully!');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $imagePath = Yii::getAlias('@webroot' . $model->image);

        if ($model->delete() && file_exists($imagePath)) {
            unlink($imagePath);
        }

        return $this->redirect(['index']);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

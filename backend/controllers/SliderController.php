<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use \yii\web\Response;
use yii\web\Controller;
use common\models\myAPI;
use common\models\Slider;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\PictureSlider;
use yii\web\NotFoundHttpException;
use common\models\searchs\SliderSearch;

class SliderController extends Controller
{
    public function behaviors()
    {
        $arr_action = ['index', 'create', 'update', 'delete', 'delete-picture'];
        $rules = [];
        foreach ($arr_action as $item) {
            $rules[] = [
                'actions' => [$item],
                'allow' => true,
                'matchCallback' => function ($rule, $action) {
                    $action_name = strtolower(str_replace('action', '', $action->id));
                    return myAPI::isAccess2('Slider', $action_name);
                }
            ];
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {    
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** create */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Slider();  

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
       
    }

    /** update */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $pricture_sliders = $model->pictureSliders;       

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'pricture_sliders' => $pricture_sliders,
            ]);
        }
    }

    /** delete */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /** delete-picture */
    public function actionDeletePicture()
    {
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['id'])) {
                $picture_slider = PictureSlider::findOne($_POST['id']);
                if (is_null($picture_slider)) {
                    throw new HttpException(500, 'Ảnh không tồn tại');
                }
                if ($picture_slider->delete()) {
                    if ($picture_slider->slider->representation == $picture_slider->file) {
                        $picture_slider = PictureSlider::findOne(['slider_id' => $picture_slider->slider_id]);
                        $picture_slider->slider->updateAttributes(['representation' => $picture_slider->file]);
                    }
                }
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    protected function findModel($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Slider không tồn tại');
        }
    }
}

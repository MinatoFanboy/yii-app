<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use \yii\web\Response;
use yii\web\Controller;
use common\models\myAPI;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use common\models\Trademark;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\searchs\TrademarkSearch;

class TrademarkController extends Controller
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
                    return myAPI::isAccess2('Trademark', $action_name);
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
        $searchModel = new TrademarkSearch();
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
        $model = new Trademark();  

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

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /** delete */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => 'Xóa bản ghi!',
                'content' => 'Đã xóa bản ghi thành công',
            ];
        }else{
            return $this->redirect(['index']);
        }
    }

    /** delete-picture */
    public function actionDeletePicture()
    {
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['id'])) {
                $model = $this->findModel($_POST['id']);

                $path = dirname(dirname(__DIR__)).'/images/trademark/'.$model->file;
                if(is_file($path)){
                    unlink($path);
                    $model->updateAttributes(['file' => 'no-image.jpeg']);
                }
                
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => 'Xóa ảnh đại diện',
                    'content' => 'Đã xóa ảnh đại diện thành công!',
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    protected function findModel($id)
    {
        if (($model = Trademark::findOne(['id' => $id, 'active' => myAPI::ACTIVE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Thương hiệu không tồn tại');
        }
    }
}

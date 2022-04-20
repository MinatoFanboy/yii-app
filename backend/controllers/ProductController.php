<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use \yii\web\Response;
use yii\web\Controller;
use common\models\myAPI;
use common\models\Product;
use yii\filters\VerbFilter;
use common\models\Trademark;
use yii\helpers\ArrayHelper;
use common\models\ProductType;
use yii\web\NotFoundHttpException;
use common\models\searchs\ProductSearch;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {    
        $searchModel = new ProductSearch();
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
        $model = new Product();  
        $trademarks = ArrayHelper::map(Trademark::findAll(['active' => myAPI::ACTIVE]), 'id', 'name');
        $product_types = ArrayHelper::map(ProductType::findAll(['active' => myAPI::ACTIVE]), 'id', 'name');

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'trademarks' => $trademarks
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
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            return $this->redirect(['index']);
        }
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id, 'active' => myAPI::ACTIVE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Sản phẩm không tồn tại');
        }
    }
}

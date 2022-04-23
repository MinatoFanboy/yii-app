<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use \yii\web\Response;
use yii\web\Controller;
use common\models\myAPI;
use common\models\Product;
use yii\helpers\VarDumper;
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
                'trademarks' => $trademarks,
                'product_types' => $product_types,
            ]);
        }
    }

    /** update */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);     
        $trademarks = ArrayHelper::map(Trademark::findAll(['active' => myAPI::ACTIVE]), 'id', 'name');
        $product_types = ArrayHelper::map(ProductType::findAll(['active' => myAPI::ACTIVE]), 'id', 'name');   
        $product_images = $model->productImages;  

        $product_product_types = [];
        foreach ($model->productProductTypes as $productProductType) {
            $product_product_types[] = $productProductType->product_type_id.'';
        }
        $model->product_types = $product_product_types;

        $keywords = [];
        foreach ($model->productKeywords as $productKeyword) {
            $keywords[] = $productKeyword->keyword->name;
        }
        $model->product_keywords = implode(',', $keywords);

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'trademarks' => $trademarks,
                'product_types' => $product_types,
                'product_images' => $product_images,
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

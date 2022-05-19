<?php
namespace frontend\controllers;

use Yii;
use common\models\myAPI;
use common\models\Product;
use yii\filters\AccessControl;
use frontend\controllers\CustomController;

class ProductController extends CustomController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'detail', 'feature'],
                'rules' => [
                    [
                        'actions' => ['index', 'detail', 'feature'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'detail', 'feature'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {
        $products = Product::find()->andWhere(['active' => myAPI::ACTIVE])->all();

        return $this->render('index', [
            'products' => $products,
        ]);
    }

    /** detail */
    public function actionDetail($path = '')
    {
        $arr = explode('_', $path);
        $product = Product::findOne($arr[0]);
        $product_relations = Product::find()
            ->andWhere(['<>', 'id', $product->id])
            ->andWhere(['or', 
                ['trademark_name' => $product->trademark_name], 
                ['features' => $product->features], 
                ['newest' => $product->newest], 
                ['sellest' => $product->sellest]])
            ->limit(8)->all();

        return $this->render('detail', [
            'product' => $product,
            'product_relations' => $product_relations,
        ]);
    }

    /** feature */
    public function actionFeature()
    {
        $products = Product::find()->andWhere(['active' => myAPI::ACTIVE])->andWhere(['features' => 1])->all();

        return $this->render('feature', [
            'products' => $products,
        ]);
    }
}

<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\myAPI;
use common\models\Product;
use yii\web\HttpException;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'feature'],
                'rules' => [
                    [
                        'actions' => ['index', 'feature'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex($path = '')
    {
        $products = Product::find()->andWhere(['active' => myAPI::ACTIVE]);
        if ($path) {
        }

        $products = $products->all();

        return $this->render('index', [
            'products' => $products,
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

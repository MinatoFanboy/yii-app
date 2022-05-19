<?php
namespace frontend\controllers;

use Yii;
use common\models\myAPI;
use common\models\Product;
use yii\filters\AccessControl;
use frontend\controllers\CustomController;

class KeywordController extends CustomController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex($path)
    {
        $arr = explode('_', $path);

        $products = Product::find()
            ->leftJoin('product_keyword', 'product_keyword.product_id = product.id')
            ->andWhere(['product_keyword.keyword_id' => $arr[0]])
            ->groupBy('product.id')
            ->andWhere(['active' => myAPI::ACTIVE])->all();

        return $this->render('../product/index', [
            'products' => $products,
        ]);
    }
}

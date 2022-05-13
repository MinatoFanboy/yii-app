<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Order;
use common\models\DonHang;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\searchs\OrderSearch;
use common\models\search\DonHangSearch;

class OrderController extends Controller
{
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

    /** index */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        $orders = Order::find()->all();

        return $this->render('index', [
            'orders' => $orders,
        ]);
    }
}

<?php

namespace frontend\controllers;

use Yii;
use common\models\Order;
use yii\filters\VerbFilter;
use frontend\controllers\CustomController;

class OrderController extends CustomController
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

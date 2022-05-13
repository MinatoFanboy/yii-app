<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use yii\web\Controller;
use common\models\Order;
use common\models\Product;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use common\models\OrderDetail;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class ShoppingCartController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'add-product', 'update-product'],
                'rules' => [
                    [
                        'actions' => ['add-product'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'add-product', 'update-product'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex() {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        
        if(isset(Yii::$app->session['product'])){
            $products = Yii::$app->session['product'];
            $quantity = Yii::$app->session['quantity'];
            $total_money = Yii::$app->session['total_money'];
            $total = Yii::$app->session['total'];
        }else{
            $products = [];
            $quantity = [];
            $total_money = 0;
            $total = 0;
        }
        if (Yii::$app->request->post()) {
            $model = new Order();
            $model->customer_id = Yii::$app->user->id;

            if(isset(Yii::$app->session['product'])){
                $products = Yii::$app->session['product'];
                $quantity = Yii::$app->session['quantity'];
                $total_money = Yii::$app->session['total_money'];
                $total = Yii::$app->session['total'];
            
                $model->total = $total_money;
                if($model->save()) {
                    if (!empty($products)) {
                        foreach($products as $product) {
                            $order_detail = new OrderDetail();
                            $order_detail->order_id = $model->id;
                            $order_detail->product_id = $product->id;
                            $order_detail->price = $product->price;
                            if (!$order_detail->save()) {
                                throw new HttpException(500, Html::errorSummary($order_detail));
                            }
                        }
                    }

                    unset(Yii::$app->session['san_pham']);
                    unset(Yii::$app->session['so_luong']);
                    unset(Yii::$app->session['tong_tien']);
                    unset(Yii::$app->session['tong_san_pham']);
                    Yii::$app->session->setFlash('notification',"<div class='alert alert-success'> Đã lưu đơn hàng thành công</div>");

                    return $this->redirect(['site/index']);
                } else {
                    throw new HttpException(500, Html::errorSummary($model));
                }
            }
        }


        return $this->render('index', [
            'products' => $products,
            'quantity' => $quantity,
            'total_money' => $total_money,
            'total' => $total,
        ]);
    }

    /** add-product */
    public function actionAddProduct()
    {
        if (Yii::$app->request->isAjax) {
            if(isset($_POST['num-product']) && isset($_POST['product_id'])){
                $product_id = $_POST['product_id'];
                $num = $_POST['num-product'];

                // Add product
                $products = [];
                if(isset(Yii::$app->session['product'])){
                    $products = Yii::$app->session['product'];
                }

                $product = Product::findOne($product_id);
                if (is_null($product)) {
                    throw new HttpException(500, 'Không tìm thấy sản phẩm');
                }
                $products[$product_id] = $product;

                Yii::$app->session['product'] = $products;

                // Add quantity
                $quantity = [];
                if(isset(Yii::$app->session['quantity'])){
                    $quantity = Yii::$app->session['quantity'];
                }

                if(isset($quantity[$product_id])){
                    $quantity[$product_id] += $num;
                }else{
                    $quantity[$product_id] = $num;
                }
                Yii::$app->session['quantity'] = $quantity;

                // Cal total money
                $total_money = 0;
                if(isset(Yii::$app->session['total_money'])){
                    $total_money = Yii::$app->session['total_money'];
                }
                
                $total_money += $product->price * $num;
                Yii::$app->session['total_money'] = $total_money;

                $total = 0;
                if(isset(Yii::$app->session['total'])){
                    $total = Yii::$app->session['total'];
                }
                $total += $num;
                Yii::$app->session['total'] = $total;

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'cart' => $this->renderAjax('_cart', [
                        'products' => Yii::$app->session['product'],
                        'quantity' => Yii::$app->session['quantity'],
                        'total_money' => Yii::$app->session['total_money'],
                        'total' => Yii::$app->session['total'],
                    ]),
                    'cart_wrapper' => $this->renderAjax('_cart_wrapper', [
                        'num_product' => Yii::$app->session['total'],
                    ]),
                    'message' => 'Đã đặt hàng thành công'
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    /** update-product */ 
    public function actionUpdateProduct()
    {
        if (Yii::$app->request->isAjax) {
            if(isset($_POST['product'])){
                $products = [];
                $quantity = [];
                $total_money = 0;
                $total = 0;

                foreach($_POST['product'] as $index => $item) {
                    $product_id = $index;
                    $num = $item;

                    if (intval($num) > 0) {
                        $product = Product::findOne($product_id);
                        if (is_null($product)) {
                            throw new HttpException(500, 'Không tìm thấy sản phẩm');
                        }
                        $products[$product_id] = $product;
                        $quantity[$product_id] = intval($num);
                        $total_money += $product->price * intval($num);
                        $total += intval($num);
                    }
                }
                if (empty($products)) {
                    unset(Yii::$app->session['product']);
                    unset(Yii::$app->session['quantity']);
                    unset(Yii::$app->session['total_money']);
                    unset(Yii::$app->session['total']);
                } else {
                    Yii::$app->session['product'] = $products;
                    Yii::$app->session['quantity'] = $quantity;
                    Yii::$app->session['total_money'] = $total_money;
                    Yii::$app->session['total'] = $total;
                }

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'cart' => $this->renderAjax('_cart', [
                        'products' => Yii::$app->session['product'],
                        'quantity' => Yii::$app->session['quantity'],
                        'total_money' => Yii::$app->session['total_money'],
                        'total' => Yii::$app->session['total'],
                    ]),
                    'cart_wrapper' => $this->renderAjax('_cart_wrapper', [
                        'num_product' => Yii::$app->session['total'],
                    ]),
                    'message' => 'Cập nhật giỏ hàng thành công'
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }
}
<?php
namespace backend\controllers;

use Igo;
use Yii;
use yii\web\Response;
use common\models\User;
use Twilio\Rest\Client;
use yii\web\Controller;
use common\models\Product;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use common\models\LoginForm;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'convert-japanese', 'update'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'loadform'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /** login */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /** logout */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /** loadform */
    public function actionLoadform()
    {
        if (Yii::$app->request->isAjax) {
            $content = '';
            $title = '';
            Yii::$app->response->format = Response::FORMAT_JSON;

            if (isset($_POST['type'])) {
                if ($_POST['type'] == 'checkbox') {
                    if (isset($_POST['User'])) {
                        $users = User::find()->andWhere(['in', 'id', $_POST['User']])->all();

                        $title = 'Checkbox';
                        $content = $this->renderAjax('../user/_form_checkbox', ['users' => $users]);
                    }
                }
            } else {
                throw new HttpException(500, 'Không xác thực được dữ liệu');
            }

            return [
                'content' => $content,
                'title' => $title,
            ];
        } else {
            throw new HttpException(500, 'Đường dẫn sai cú pháp');
        }
    }

    /** send-message */
    public function actionSendMessage()
    {
        $sid = "AC2311b1737bdea60ab410404e9c383c64";
        $token = "a908f00dceb3e0f446220a7562300c81";
        $twilio = new Client($sid, $token);
        $message = $twilio->messages
            ->create("+84335525344",
                array(
                    "messagingServiceSid" => "MGeb59e4861b1bea621bba89c3862b2037",
                    "body" => "01234",
                )
            );

//        "sid": "SMf8da7e24b4ed43778d30dc2c757b3d7a",
        //        "date_created": "Fri, 24 Dec 2021 09:53:27 +0000",
        //        "date_updated": "Fri, 24 Dec 2021 09:53:27 +0000",
        //        "date_sent": null,
        //        "account_sid": "AC2311b1737bdea60ab410404e9c383c64",
        //        "to": "+84399325199",
        //        "from": null,
        //        "messaging_service_sid": "MGeb59e4861b1bea621bba89c3862b2037",
        //        "body": "105634",
        //        "status": "accepted",
        //        "num_segments": "0",
        //        "num_media": "0",
        //        "direction": "outbound-api",
        //        "api_version": "2010-04-01",
        //        "price": null,
        //        "price_unit": null,
        //        "error_code": null,
        //        "error_message": null,
        //        "uri": "/2010-04-01/Accounts/AC2311b1737bdea60ab410404e9c383c64/Messages/SMf8da7e24b4ed43778d30dc2c757b3d7a.json",
        //        "subresource_uris": {
        //            "media": "/2010-04-01/Accounts/AC2311b1737bdea60ab410404e9c383c64/Messages/SMf8da7e24b4ed43778d30dc2c757b3d7a/Media.json"
        //        }
    }

    /** convert-japanese */
    public function actionConvertJapanese()
    {
        $igo = new Igo\Tagger();

        $title = '誤嚥性肺炎';

        $result = $igo->parse($title);
        $str = "";
        $data = [];
        foreach ($result as $value) {
            $feature = $value->feature;
            $str .= isset($feature[7]) ? $feature[7] : $value->surface;
        }

        $data['furigana'] = mb_convert_kana($str, "c", "utf-8");

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.kuroshiro.org/convert',
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => http_build_query(array(
                'mode' => 'normal',
                'romajiSystem' => 'nippon',
                'str' => $title,
                'to' => 'hiragana',
            )),
        ));
        $resp = curl_exec($curl);
        $data['hiragana'] = json_decode($resp, true)['result'];

        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.kuroshiro.org/convert',
            CURLOPT_POST => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => http_build_query(array(
                'mode' => 'normal',
                'romajiSystem' => 'nippon',
                'str' => $title,
                'to' => 'katakana',
            )),
        ));
        $resp = curl_exec($curl);
        $data['katakana'] = json_decode($resp, true)['result'];

        VarDumper::dump($data, 10, true);

        curl_close($curl); exit();
    }

    /** update */
    public function actionUpdate() {
        $products = Product::find()->all();
        foreach ($products as $product) {
            $arr_product_type = [];
            foreach ($product->productProductTypes as $productProductType) {
                $arr_product_type[] = $productProductType->productType->slug;
            }
            $product->updateAttributes(['class_type' => implode(' ', $arr_product_type)]);
        }
    }
}

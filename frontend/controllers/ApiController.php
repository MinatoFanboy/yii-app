<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use common\models\User;
use common\models\myAPI;
use common\models\Notification;
use yii\rest\Controller;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\helpers\FileHelper;
use common\models\Trademark;

class ApiController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Allow-Origin' => ['*', 'http://10.0.3.2'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    /** login */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        if (!$request->isGet) {
            throw new HttpException(400, 'Request is not accepted');
        } else {
            if (!isset($_GET['username']) || !$_GET['username']) {
                throw new HttpException(404, 'Mật khẩu không được để trống');
            }
            if (!isset($_GET['password']) || !$_GET['password']) {
                throw new HttpException(404, 'Mật khẩu không được để trống');
            }

            $user = User::findOne(['username' => $_GET['username']]);
            if (is_null($user)) {
                throw new HttpException(404, 'Thông tin đăng nhập không tồn tại');
            }
            if ($user->validatePassword($_GET['password'])) {
                return $user;
            } else {
                throw new HttpException(404, 'Tên đăng nhập hoặc mật khẩu không chính xác');
            }
        }
    }

    /** get-trademark */
    public function actionGetTrademark()
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$request->isGet) {
            throw new HttpException(400, 'Request is not accepted');
        } else {
            $trademarks = Trademark::find()->andWhere(['active' => myAPI::ACTIVE])->all();

            return $trademarks;
        }
    }

    /** add-trademark */
    public function actionAddTrademark()
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$request->isPost) {
            throw new HttpException(400, 'Request is not accepted');
        } else {
            $trademark = new Trademark();
            $trademark->name = $request->post('name');
            $trademark->slug = myAPI::createCode($trademark->name);
            $file = UploadedFile::getInstanceByName('file');
            if (!is_null($file)) {
                $trademark->file = date('Y/m/d') . '/' . $trademark->slug . myAPI::get_extension_image($file->type);
            }
            if ($trademark->save()) {
                if (!is_null($file)) {
                    $path = dirname(dirname(__DIR__)) . '/images/trademark/';
                    if (FileHelper::createDirectory($path . date('Y/m/d') . '/', $mode = 0775, $recursive = true)) {
                        $file->saveAs($path . $trademark->file);
                    }
                }

                return [
                    'status' => true,
                    'title' => 'Lưu thương hiệu',
                    'content' => 'Đã lưu thương hiệu thành công',
                ];
            } else {
                return [
                    'status' => false,
                    'title' => 'Lưu thương hiệu',
                    'content' => 'Có lỗi xảy ra. Vui lòng thử lại',
                ];
            }
        }
    }

    /** get-notification */
    public function actionGetNotification() {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$request->isGet) {
            throw new HttpException(400, 'Request is not accepted');
        } else {
            $page = 1;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            }
            $notifications = Notification::find()->limit(12)->offset(($page - 1) * 12)->all();

            return $notifications;
        }
    }

    /** upload */
    public function actionUpload()
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$request->isPost) {
            throw new HttpException(400, 'Request is not accepted');
        } else {
            if ($request->post('name')) {
                $trademark = new Trademark();
                $trademark->name = $request->post('name');
                $trademark->slug = myAPI::createCode($trademark->name);
                $file = UploadedFile::getInstanceByName('file');
                if (!is_null($file)) {
                    $trademark->file = date('Y/m/d') . '/' . $trademark->slug . myAPI::get_extension_image($file->type);
                }
                if ($trademark->save()) {
                    if (!is_null($file)) {
                        $path = dirname(dirname(__DIR__)) . '/images/trademark/';
                        if (FileHelper::createDirectory($path . date('Y/m/d') . '/', $mode = 0775, $recursive = true)) {
                            $file->saveAs($path . $trademark->file);
                        }
                    }

                    return [
                        'status' => true,
                        'title' => 'Lưu thương hiệu',
                        'content' => 'Đã lưu thương hiệu thành công',
                    ];
                } else {
                    return [
                        'status' => false,
                        'title' => 'Lưu thương hiệu',
                        'content' => 'Có lỗi xảy ra. Vui lòng thử lại',
                    ];
                }
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        }
    }
}

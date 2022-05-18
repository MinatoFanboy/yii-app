<?php
namespace frontend\controllers;

use Yii;
use common\models\myAPI;
use yii\rest\Controller;
use yii\web\UploadedFile;
use yii\web\HttpException;
use yii\helpers\FileHelper;
use common\models\Trademark;

class ApiController extends Controller
{
    public function actionUpload() {
        if (isset($_POST['name'])) {
            $trademark = new Trademark();
            $trademark->name = $_POST['name'];
            $trademark->slug = myAPI::createCode($trademark->name);
            $file = UploadedFile::getInstanceByName('file');
            if (!is_null($file)) {
                $trademark->file = date('Y/m/d') . '/' . $trademark->slug . myAPI::get_extension_image($file->type);
            }
            if ($trademark->save()) {
                if (!is_null($file)) {
                    $path = dirname(dirname(__DIR__)).'/images/trademark/';
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

<?php

namespace backend\controllers;

use common\models\Note;
use common\models\myAPI;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;

class TableController extends BaseController
{
    public function behaviors()
    {
        $arr_action = ['index', 'add-new-row', 'save', 'delete', 'delete-file'];
        $rules = [];
        foreach ($arr_action as $item) {
            $rules[] = [
                'actions' => [$item],
                'allow' => true,
                'matchCallback' => function ($rule, $action) {
                    $action_name = strtolower(str_replace('action', '', $action->id));
                    return myAPI::isAccess2('Table', $action_name);
                }
            ];
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {
        $ghiChus = Note::find()->all();

        return $this->render('index', [
            'ghiChus' => $ghiChus
        ]);
    }

    /** add-new-row */
    public function actionAddNewRow()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if (isset($_POST['count'])) {
                return [
                    'content' => $this->renderAjax('new_row', [
                        'count' => intval($_POST['count']),
                    ]),
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    /** save */
    public function actionSave()
    {
        if (\Yii::$app->request->isAjax) {
            if (isset($_POST['Text'])) {
                foreach ($_POST['Text'] as $index => $item) {
                    $ghiChu = new Note();
                    $ghiChu->name = $item;
                    $ghiChu->ngay_thuc_hien = $_POST['Date'][$index];
                    if ($ghiChu->save()) {
                        $file = UploadedFile::getInstanceByName("FileDinhKem[$index]");
                        if (!is_null($file)) {
                            $path = dirname(dirname(__DIR__)).'/uploads/'.$file->name;
                            $file->saveAs($path);
                            $ghiChu->updateAttributes(['file' => $file->name]);
                        }
                    } else {
                        throw new HttpException(500, Html::errorSummary($ghiChu));
                    }
                }
            }

            if (isset($_POST['OldId'])) {
                foreach ($_POST['OldId'] as $index => $item) {
                    $ghiChu = Note::findOne($index);
                    if (!is_null($ghiChu)) {
                        $ghiChu->name = $_POST['OldText'][$index];
                        $ghiChu->ngay_thuc_hien = $_POST['OldDate'][$index];
                        if ($ghiChu->save()) {
                            $file = UploadedFile::getInstanceByName("OldFileDinhKem[$index]");
                            if (!is_null($file)) {
                                $path = dirname(dirname(__DIR__)) . '/uploads/' . $ghiChu->file;
                                if(is_file($path)){
                                    unlink($path);
                                }

                                $path = dirname(dirname(__DIR__)) . '/uploads/' . $file->name;
                                $file->saveAs($path);
                                $ghiChu->updateAttributes(['file' => $file->name]);
                            }
                        } else {
                            throw new HttpException(500, Html::errorSummary($ghiChu));
                        }
                    }
                }
            }

            $ghiChus = Note::find()->all();
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => 'Lưu table',
                'content' => 'Đã lưu thông tin table thành công',
                'body' => $this->renderAjax('table', ['ghiChus' => $ghiChus])
            ];
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    /** delete */
    public function actionDelete()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if (isset($_POST['id'])) {
                $model = $this->findModel($_POST['id']);
                $model->delete();

                return [
                    'title' => 'Xóa hàng',
                    'content' => 'Đã xóa hàng thành công',
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    /** delete-file */
    public function actionDeleteFile()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if (isset($_POST['id'])) {
                $model = $this->findModel($_POST['id']);
                $model->updateAttributes(['file' => null]);
                $path = dirname(dirname(__DIR__)) . '/uploads/' . $model->file;
                if(is_file($path)){
                    unlink($path);
                }

                return [
                    'title' => 'Xóa hàng',
                    'content' => 'Đã xóa hàng thành công',
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Người dùng không tồn tại');
        }
    }
}

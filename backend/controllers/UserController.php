<?php

namespace backend\controllers;

use common\models\exports\exportUser;
use common\models\myAPI;
use common\models\Role;
use common\models\searchs\UserSearch;
use common\models\User;
use common\models\UserRole;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use \yii\web\Response;

class UserController extends BaseController
{
    public function behaviors()
    {
        $arr_action = ['index', 'create', 'update', 'delete', 'detail', 'download', 'upload'];
        $rules = [];
        foreach ($arr_action as $item) {
            $rules[] = [
                'actions' => [$item],
                'allow' => true,
                'matchCallback' => function ($rule, $action) {
                    $action_name = strtolower(str_replace('action', '', $action->id));
                    return myAPI::isAccess2('User', $action_name);
                },
            ];
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /** create */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new User();
        $model->type = User::THANH_VIEN;
        $roles = ArrayHelper::map(Role::find()->andWhere(['status' => myAPI::ACTIVE])->andWhere(['<>', 'id', 1])->all(), 'id', 'name');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Thêm người dùng",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'roles' => $roles,
                    ]),
                    'footer' => Html::button('<i class="fas fa-times"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="fas fa-save"></i> Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"]),

                ];
            } else if ($model->load($request->post())) {
                $oldModel = User::findOne(['username' => $model->username, 'status' => User::STATUS_DELETED]);
                if (!is_null($oldModel)) {
                    $oldModel->password_hash = $model->password_hash;
                    $oldModel->name = $model->name;
                    $oldModel->phone = $model->phone;
                    $oldModel->email = $model->email;
                    $oldModel->status = User::STATUS_ACTIVE;
                    $oldModel->roles = $model->roles;
                    if ($oldModel->save()) {
                        return [
                            'forceReload' => '#crud-datatable-pjax',
                            'title' => "Thêm người dùng",
                            'content' => '<span class="text-success">Đã thêm người dùng thành công!</span>',
                            'footer' => Html::button('<i class="fa fa-close"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                            Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm tiếp', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']),

                        ];
                    } else {
                        throw new HttpException(500, Html::errorSummary($oldModel));
                    }
                } else {
                    if ($model->save()) {
                        return [
                            'forceReload' => '#crud-datatable-pjax',
                            'title' => "Thêm người dùng",
                            'content' => '<span class="text-success">Thêm người dùng thành công!</span>',
                            'footer' => Html::button('<i class="fas fa-times"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                            Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm tiếp', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']),
                        ];
                    }
                }
            } else {
                return [
                    'title' => "Thêm người dùng",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'roles' => $roles,
                    ]),
                    'footer' => Html::button('<i class="fas fa-times"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="fas fa-save"></i> Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"]),

                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /** update */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->roles = ArrayHelper::map(UserRole::findAll(['user_id' => $model->id]), 'id', 'role_id');
        $roles = ArrayHelper::map(Role::find()->andWhere(['status' => myAPI::ACTIVE])->andWhere(['<>', 'id', 1])->all(), 'id', 'name');

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Cập nhật người dùng: " . $model->username,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'roles' => $roles,
                    ]),
                    'footer' => Html::button('<i class="fas fa-times"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="fas fa-save"></i> Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"]),
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Cập nhật người dùng: " . $model->username,
                    'content' => '<span class="text-success">Đã cập nhật người dùng thành công!</span>',
                    'footer' => Html::button('<i class="fas fa-times"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('<i class="fas fa-edit"></i> Cập nhật', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']),
                ];
            } else {
                return [
                    'title' => "Cập nhật người dùng: " . $model->username,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'roles' => $roles,
                    ]),
                    'footer' => Html::button('<i class="fas fa-times"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('<i class="fas fa-save"></i> Lưu lại', ['class' => 'btn btn-primary', 'type' => "submit"]),
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'roles' => $roles,
                ]);
            }
        }
    }

    /** delete */
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['id'])) {
                $model = $this->findModel($_POST['id']);
                $model->updateAttributes(['status' => User::STATUS_DELETED]);

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => 'Xóa bản ghi!',
                    'content' => 'Đã xóa bản ghi thành công',
                ];
            } else {
                throw new NotFoundHttpException('Không xác thực được dữ liệu');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    /** detail */
    public function actionDetail()
    {
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['id'])) {
                $model = $this->findModel($_POST['id']);

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => 'Thông tin người dùng',
                    'content' => $this->renderAjax('detail', [
                        'model' => $model,
                    ]),
                ];
            } else {
                throw new NotFoundHttpException('Người dùng không tồn tại');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    /** download */
    public function actionDownload()
    {
        if (Yii::$app->request->isAjax) {
            $users = User::find()->all();

            $export = new exportUser();
            $export->data = $users;
            $export->path = dirname(dirname(__DIR__)) . '/excels/';
            $file_name = $export->init();
            $file = str_replace('index.php', '', Yii::$app->request->baseUrl) . '/../excels/' . $file_name;

            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => 'Tải file kết quả',
                'link' => Html::a('<i class="fa fa-cloud-download"></i> Nhấn vào đây để tải file về!', $file, ['class' => 'text-primary', 'target' => '_blank']),
            ];
        } else {
            throw new HttpException(500, 'Đường dẫn sai cú pháp');
        }
    }

    /** upload */
    public function actionUpload()
    {
        if (Yii::$app->request->isAjax) {
            $file = UploadedFile::getInstanceByName('file');
            $path = dirname(dirname(__DIR__)) . '/uploads/';
            $fileName = myAPI::createCode($file->name);
            $filePath = $path . date('Y/m/d') . '/' . $fileName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            try {
                if (FileHelper::createDirectory($path . date('Y/m/d') . '/', $mode = 0775, $recursive = true)) {
                    $file->saveAs($filePath);
                }
            } catch (\Exception $ex) {
                if (is_file($filePath)) {
                    unlink($filePath);
                }
                throw new HttpException(500, $ex->getMessage());
            }
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (is_file($filePath)) {
                $reader = IOFactory::createReaderForFile($filePath);
                $spreadsheet = $reader->load($filePath);

                $activeSheet = $spreadsheet->getActiveSheet();
                $highestRow = $activeSheet->getHighestRow();
                for ($row = 4; $row <= $highestRow; $row++) {
                    $tempt = [];
                    $tempt['username'] = (string) trim($activeSheet->getCell('B' . $row)->getValue());
                    $tempt['password_hash'] = (string) trim($activeSheet->getCell('C' . $row)->getValue());
                    $tempt['ho_ten'] = (string) trim($activeSheet->getCell('D' . $row)->getValue());
                    $tempt['dien_thoai'] = (string) trim($activeSheet->getCell('E' . $row)->getValue());
                    $tempt['email'] = (string) trim($activeSheet->getCell('F' . $row)->getValue());
                    $data[] = $tempt;
                }
                VarDumper::dump($data, $depth = 10, $highlight = true);exit();

                return [
                    'title' => 'Upload thông tin user',
                    'content' => 'Đã upload thông tin user thành công',
                ];
            } else {
                return [
                    'title' => 'Upload thông tin user',
                    'content' => 'Có lỗi xảy ra. Vui lòng thử lại',
                ];
            }
        } else {
            throw new NotFoundHttpException(500, 'Đường dẫn sai cú pháp.');
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id, 'type' => User::THANH_VIEN])) !== null) {
            if ($id === 1 && Yii::$app->user->id !== 1) {
                throw new NotFoundHttpException('Bạn không được phép sửa người dùng này');
            } else {
                return $model;
            }
        } else {
            throw new NotFoundHttpException('Người dùng không tồn tại');
        }
    }
}

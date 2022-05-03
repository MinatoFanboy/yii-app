<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use \yii\web\Response;
use common\models\Role;
use common\models\myAPI;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\searchs\RoleSearch;

class RoleController extends BaseController
{
    public function behaviors()
    {
        $arr_action = ['index', 'create', 'update', 'delete'];
        $rules = [];
        foreach ($arr_action as $item) {
            $rules[] = [
                'actions' => [$item],
                'allow' => true,
                'matchCallback' => function ($rule, $action) {
                    $action_name = strtolower(str_replace('action', '', $action->id));
                    return myAPI::isAccess2('Role', $action_name);
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
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
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
        $model = new Role();

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm vai trò",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fas fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm vai trò",
                    'content'=>'<span class="text-success">Thêm vai trò thành công!</span>',
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm tiếp',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Thêm vai trò",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fas fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
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

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật vai trò: ".$model->name,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fas fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Vai trò: ".$model->name,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="fas fa-edit"></i> Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Cập nhật vai trò: ".$model->name,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fas fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /** delete */
    public function actionDelete(){
        if(Yii::$app->request->isAjax){
            if(isset($_POST['id'])){
                $model = $this->findModel($_POST['id']);
                $model->updateAttributes(['status' => myAPI::IN_ACTIVE]);

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'title' => 'Xóa bản ghi!',
                    'content' => 'Đã xóa bản ghi thành công',
                ];
            }else{
                throw new NotFoundHttpException('Không xác thực được dữ liệu');
            }
        }else{
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            if ($id === 1 && Yii::$app->user->id !== 1) {
                throw new NotFoundHttpException('Bạn không được phép sửa vai trò này');
            } else {
                return $model;
            }
        } else {
            throw new NotFoundHttpException('Vai trò không tồn tại');
        }
    }
}

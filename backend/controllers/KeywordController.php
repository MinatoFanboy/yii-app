<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use \yii\web\Response;
use yii\web\Controller;
use common\models\myAPI;
use common\models\Keyword;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\searchs\KeywordSearch;

class KeywordController extends Controller
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
                    return myAPI::isAccess2('Keyword', $action_name);
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
                ],
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {    
        $searchModel = new KeywordSearch();
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
        $model = new Keyword();  

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới từ khóa",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('<i class="fas fa-save"></i> Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post())){
                $oldModel = Keyword::findOne(['name' => $model->name, 'active' => myAPI::IN_ACTIVE]);
                if (!is_null($oldModel)) {
                    $oldModel->updateAttributes(['active' => myAPI::ACTIVE]);
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Từ khóa: ".$model->name,
                        'content'=>'<span class="text-success">Đã thêm từ khóa thành công!</span>',
                        'footer'=> Html::button('<i class="fa fa-close"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm tiếp',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                    ];
                } else {
                    if ($model->save()) {
                        return [
                            'forceReload'=>'#crud-datatable-pjax',
                            'title'=> "Từ khóa: ".$model->name,
                            'content'=>'<span class="text-success">Cập nhật loại sản phẩm thành công</span>',
                            'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm tiếp',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                        ];    
                    }
                }
            }else{           
                return [
                    'title'=> "Thêm mới từ khóa",
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
                    'title'=> "Cập nhật từ khóa: ".$model->name,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm tiếp',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Từ khóa: ".$model->name,
                    'content'=>'<span class="text-success">Cập nhật từ khóa thành công</span>',
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('<i class="fas fa-edit"></i> Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Cập nhật từ khóa: ".$model->name,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('<i class="fas fa-times"></i> Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('<i class="fas fa-edit"></i> Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->updateAttributes(['active' => myAPI::IN_ACTIVE]);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => 'Xóa bản ghi!',
                'content' => 'Đã xóa bản ghi thành công',
            ];
        }else{
            return $this->redirect(['index']);
        }
    }
    protected function findModel($id)
    {
        if (($model = Keyword::findOne(['id' => $id, 'active' => myAPI::ACTIVE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Từ khóa không tồn tại');
        }
    }
}

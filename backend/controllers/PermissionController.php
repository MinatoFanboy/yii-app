<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Response;
use common\models\Role;
use common\models\myAPI;
use yii\web\HttpException;
use common\models\Activity;
use yii\helpers\ArrayHelper;
use common\models\Permission;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class PermissionController extends CoreController
{
    public function behaviors()
    {
        $arr_action = ['index', 'load', 'save'];
        $rules = [];
        foreach ($arr_action as $item) {
            $rules[] = [
                'actions' => [$item],
                'allow' => true,
                'matchCallback' => function ($rule, $action) {
                    $action_name = strtolower(str_replace('action', '', $action->id));
                    return myAPI::isAccess2('Permission', $action_name);
                }
            ];
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $rules,
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {
        $groups = ArrayHelper::map(Activity::find()->distinct('group')->all(), 'group', 'group');
        $roles = ArrayHelper::map(Role::find()->andWhere(['<>', 'id', 1])->andWhere(['status' => myAPI::ACTIVE])->all(), 'id', 'name');

        return $this->render('index', [
            'groups' => $groups, 
            'roles' => $roles
        ]);
    }

    /** load */
    public function actionLoad()
    {
        if (Yii::$app->request->isAjax) {
            if ($_POST['group']) {
                $activities = Activity::find()->andWhere(['group' => $_POST['group']])->all();
                $roles = ArrayHelper::map(Role::find()->andWhere(['<>', 'id', 1])->andWhere(['status' => myAPI::ACTIVE])->all(), 'id', 'name');

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'body' => $this->renderAjax('row', [
                        'activities' => $activities,
                        'roles' => $roles,
                    ]),
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu gửi lên');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }

    /** save */
    public function actionSave()
    {
        if (Yii::$app->request->isAjax) {
            if ($_POST['Permission']) {
                foreach ($_POST['Permission'] as $activity_id => $item) {
                    foreach ($item as $role_id => $content) {
                        $permission = new Permission();
                        $permission->activity_id = $activity_id;
                        $permission->role_id = $role_id;
                        if (!$permission->save()) {
                            throw new HttpException(500, Html::errorSummary($permission));
                        }
                    }

                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return [
                        'tilte' => 'Lưu phân quyền',
                        'roles' => 'Đã lưu phân quyền thành công',
                    ];
                }
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu gửi lên');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }
}

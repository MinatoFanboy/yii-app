<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

class ResetPasswordForm extends Model
{
    public $password;
    public $new_password;
    public $repeat_new_password;

    private $_user;

    public function rules()
    {
        return [
            [['password', 'new_password', 'repeat_new_password'], 'required', 'message' => '{attribute} không được để trống'],
            ['password', 'validatePassword'],
            ['repeat_new_password', 'compareNewPassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Mật khẩu hiện tại',
            'new_password' => 'Mật khẩu mới',
            'repeat_new_password' => 'Nhập lại mật khẩu',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!Yii::$app->security->validatePassword($this->password, Yii::$app->user->password_hash)) {
                $this->addError($attribute, 'Mật khẩu không chính xác');
            }
        }
    }

    public function compareNewPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->new_password !== $this->repeat_new_password) {
                $this->addError($attribute, 'Mật khẩu mới không giống nhau');
            }
        }
    }

    public function changePassword()
    {
        if ($this->validate()) {
            User::updateAll(['password_hash' => Yii::$app->security->generatePasswordHash($this->new_password)], ['id' => Yii::$app->user->id]);
            return true;
        }

        return false;
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}

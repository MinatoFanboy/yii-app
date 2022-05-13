<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use common\models\User;
use yii\web\HttpException;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $phone;
    public $address;

    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'password', 'name', 'phone', 'address'], 'required', 'message' => '{attribute} không được để trống'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Tên đăng nhập đã được sử dụng'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Email đã tồn tại'],

            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'name' => 'Họ tên',
            'phone' => 'Điện thoại',
            'address' => 'Địa chỉ',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->password_hash = $this->password;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->type = User::KHACH_HANG;
        $user->status = User::STATUS_ACTIVE;
        if ($user->save()) {
            return true;
        } else {
            throw new HttpException(500, Html::errorSummary($user));
        }

    }

    // protected function sendEmail($user)
    // {
    //     return Yii::$app
    //         ->mailer
    //         ->compose(
    //             ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
    //             ['user' => $user]
    //         )
    //         ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
    //         ->setTo($this->email)
    //         ->setSubject('Account registration at ' . Yii::$app->name)
    //         ->send();
    // }
}

<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use common\models\User;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\swiftmailer\Mailer;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => '{attribute} không được để trống.'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'Không tìm được tài khoản nào ứng với email này.'
            ],
        ];
    }

    // public function sendEmail()
    // {
    //     /* @var $user User */
    //     $user = User::findOne([
    //         'status' => User::STATUS_ACTIVE,
    //         'email' => $this->email,
    //     ]);

    //     if (!$user) {
    //         return false;
    //     }
        
    //     if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
    //         $user->generatePasswordResetToken();
    //         if (!$user->save()) {
    //             throw new HttpException(500, Html::errorSummary($user));
    //             return false;
    //         }
    //     }

    //     $yiiMailer = new Mailer();
    //     $transPort = new \Swift_SmtpTransport('smtp.gmail.com', '465', 'SSL');
    //     $transPort->setUsername('thanhpt.work@gmail.com');
    //     $transPort->setPassword('31299t@P');
    //     $yiiMailer->setTransport($transPort);

    //     return
    //         $yiiMailer->compose(
    //             ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
    //             ['user' => $user]
    //         )->setCharset('utf8')
    //             ->setFrom(['thanhpt.work@gmail.com' => 'My Application'])
    //             ->setTo($this->email)
    //             ->setSubject('Yêu cầu khôi phục mật khẩu của '.Yii::$app->name)->send();
    // }

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom('thanhpt.work@gmail.com')
            ->setTo($this->email)
            ->setSubject('Yêu cầu khôi phục mật khẩu của ' . Yii::$app->name)
            ->send();
    }
}

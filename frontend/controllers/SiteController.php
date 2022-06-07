<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use common\models\myAPI;
use common\models\Keyword;
use common\models\Product;
use yii\web\HttpException;
use common\models\LoginForm;
use common\models\ProductType;
use common\models\SliderImage;
use yii\filters\AccessControl;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use frontend\models\VerifyEmailForm;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use frontend\controllers\BaseController;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'view-modal-product', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['index', 'view-modal-product', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'view-modal-product'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    // public function beforeAction($action)
    // {
    //     $this->enableCsrfValidation = false;

    //     return parent::beforeAction($action);
    // }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /** index */
    public function actionIndex()
    {
        $sliders = SliderImage::find()->limit(3)->all();
        $product_types = ProductType::find()->andWhere(['active' => myAPI::ACTIVE])->limit(5)->all();
        $keywords = Keyword::find()->andWhere(['active' => myAPI::ACTIVE])->limit(3)->all();
        $products = Product::find()->andWhere(['active' => myAPI::ACTIVE])->limit(16)->all();

        return $this->render('index', [
            'sliders' => $sliders,
            'product_types' => $product_types,
            'keywords' => $keywords,
            'products' => $products,
        ]);
    }

    /** login */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /** logout */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /** contact */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /** about */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /** signup */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('notification', '<div class="alert alert-success">Cảm ơn đã đăng ký. Vui lòng đăng nhập lại.</div>');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /** request-password-reset */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('notification', '<div class="alert alert-success">Chúng tôi đã gửi đương dẫn khôi phục mật khẩu đến email của bạn. Vui lòng đăng nhập và xác thực.</div>');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('notification', '<div class="alert alert-danger">Không thể tìm thấy email.</div>');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /** reset-password */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('notification', '<div class="alert alert-success">Đã lưu mật khẩu mới thành công</div>');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /** verify-email */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /** resend-verification-email */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /** view-modal-product */
    public function actionViewModalProduct() {
        if (Yii::$app->request->isAjax) {
            if (isset($_POST['id'])) {
                $product = Product::findOne($_POST['id']);
                if (is_null($product)) {
                    throw new HttpException(500, 'Không tìm thấy thông tin sản phẩm');
                }

                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'content' => $this->renderAjax('modal', ['product' => $product]),
                ];
            } else {
                throw new HttpException(500, 'Không xác thực dữ liệu gửi lên');
            }
        } else {
            throw new NotFoundHttpException('Đường dẫn sai cú pháp');
        }
    }
}

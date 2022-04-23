<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use common\models\User;
use yii\web\Controller;
use common\models\myAPI;
use common\models\Slider;
use common\models\TuKhoa;
use common\models\DonHang;
use common\models\Product;
use common\models\SanPham;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use common\models\PhanLoai;
use yii\filters\VerbFilter;
use yii\swiftmailer\Mailer;
use common\models\AnhSlider;
use common\models\LoginForm;
use common\models\ProductType;
use common\models\SliderImage;
use yii\filters\AccessControl;
use frontend\models\SignupForm;
use common\models\QuanLySanPham;
use common\models\TuKhoaSanPham;
use frontend\models\ContactForm;
use common\models\ChiTietSanPham;
use common\models\PhanLoaiSanPham;
use frontend\models\VerifyEmailForm;
use yii\web\BadRequestHttpException;
use frontend\models\ResetPasswordForm;
use yii\base\InvalidArgumentException;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
        $products = Product::find()->andWhere(['active' => myAPI::ACTIVE])->limit(16)->all();

        return $this->render('index', [
            'sliders' => $sliders,
            'product_types' => $product_types,
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
            Yii::$app->session->setFlash('success', 'Cảm ơn đã đăng ký. Vui lòng đăng nhập lại.');
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
                Yii::$app->session->setFlash('thongbao', '<div class="alert alert-success">Chúng tôi đã gửi đương dẫn khôi phục mật khẩu đến email của bạn. Vui lòng đăng nhập và xác thực.</div>');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('thongbao', '<div class="alert alert-danger">Không thể tìm thấy email.</div>');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('thongbao', '<div class="alert alert-success">Đã lưu mật khẩu mới thành công</div>');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
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

    /**
     * Resend verification email
     *
     * @return mixed
     */
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

    /** phan-loai*/
    public function actionTuKhoa($path)
    {
        $tu_khoa = TuKhoa::findOne(['code' => $path]);
        $san_phams = [];
        if(is_array($tu_khoa->tuKhoaSanPhams)){
            foreach ($tu_khoa->tuKhoaSanPhams as $item){
                /** @var $item TuKhoaSanPham */
                $san_phams[] = $item->sanPham;
            }
        }
        return $this->render('tu_khoa', [
            'san_phams' => $san_phams,
            'tu_khoa' => $tu_khoa
        ]);
    }

    /** phan-loai */
    public function actionPhanLoai($path)
    {
        $phan_loai = PhanLoai::findOne(['code' => $path]);
        $san_phams = [];
        if(is_array($phan_loai->phanLoaiSanPhams)){
            foreach ($phan_loai->phanLoaiSanPhams as $item){
                /** @var $item PhanLoaiSanPham */
                $san_phams[] = $item->sanPham;
            }
        }
        return $this->render('phan_loai', [
            'san_phams' => $san_phams,
            'phan_loai' => $phan_loai
        ]);
    }

    /** phan-loai */
    public function actionSanPham($path)
    {
        $san_pham = SanPham::findOne(['code' => $path]);
        return $this->render('san_pham', [
            'san_pham' => $san_pham,
        ]);
    }

    /** cua-hang */
    public function actionCuaHang()
    {
        return $this->render('cua_hang');
    }

    /** lien-he */
    public function actionLienHe()
    {
        return $this->render('lien_he');
    }

    /** add-to-cart */
    public function actionAddToCart()
    {
        $flag = 'Trang chủ';
        if(isset($_GET['so_luong_san_pham'])){
            $flag = 'Trang chi tiết';
            $data = $_GET['san_pham'];
            $so_luong_dat_them = $_GET['so_luong_san_pham'];
        }else{
            $data = $_GET['code'];
            $so_luong_dat_them = 1;
        }
        $arr = explode('-', $data);
        $arr = array_reverse($arr);
        $id = $arr[0];

        // Gán sản phẩm
        $san_pham = [];
        if(isset(Yii::$app->session['san_pham'])){
            $san_pham = Yii::$app->session['san_pham'];
        }
        $san_pham[$id] = SanPham::findOne($id);
        $san_pham_da_dat = SanPham::findOne($id);
        Yii::$app->session['san_pham'] = $san_pham;

        // Gán số lượng
        $so_luong_sp = [];
        if(isset(Yii::$app->session['so_luong'])){
            $so_luong_sp = Yii::$app->session['so_luong'];
        }
        if(isset($so_luong_sp[$id])){
            $so_luong_sp[$id] += $so_luong_dat_them;
        }else{
            $so_luong_sp[$id] = $so_luong_dat_them;
        }
        Yii::$app->session['so_luong'] = $so_luong_sp;

        // Gán tổng tiền đã đặt
        $tong_tien = 0;
        if(isset(Yii::$app->session['tong_tien'])){
            $tong_tien = Yii::$app->session['tong_tien'];
        }
        $tong_tien += $san_pham_da_dat->gia_ban * $so_luong_dat_them;
        Yii::$app->session['tong_tien'] = $tong_tien;

        // Gán tổng số lượng
        $tong_san_pham = 0;
        if(isset(Yii::$app->session['tong_san_pham'])){
            $tong_san_pham = Yii::$app->session['tong_san_pham'];
        }
        $tong_san_pham += $so_luong_dat_them;
        Yii::$app->session['tong_san_pham'] = $tong_san_pham;

//        echo Json::encode($san_pham);

        if(is_null($san_pham)){
            throw new HttpException(500, 'Không tìm thấy sản phẩm');
        }else{
            echo Json::encode([
                'mini_cart' => $this->renderAjax('_mini_cart', [
                    'gio_hangs' => Yii::$app->session['san_pham'],
                    'so_luongs' => Yii::$app->session['so_luong'],
                    'tong_tien' => Yii::$app->session['tong_tien'],
                    'tong_so_luong' => Yii::$app->session['tong_san_pham'],
                ]),
                'mini_cart_wrapper' => $this->renderAjax('_mini_cart_wrapper', [
                    'tong_so_luong' => Yii::$app->session['tong_san_pham'],
                ]),
                'message' => 'Đã đặt hàng thành công'
            ]);
        }
    }

    /** gio-hang */
    public function actionGioHang(){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        if(isset(Yii::$app->session['san_pham'])){
            $gio_hangs = Yii::$app->session['san_pham'];
            $so_luongs = Yii::$app->session['so_luong'];
            $tong_tien = Yii::$app->session['tong_tien'];
            $tong_so_luong = Yii::$app->session['tong_san_pham'];
        }else{
            $gio_hangs = [];
            $so_luongs = [];
            $tong_tien = 0;
            $tong_so_luong = 0;
        }
        return $this->render('gio_hang', [
            'gio_hangs' => $gio_hangs,
            'so_luongs' => $so_luongs,
            'tong_tien' => $tong_tien,
            'tong_so_luong' => $tong_so_luong,
        ]);
    }

    /** update-cart */
    public function actionUpdateCart(){
        $so_luongs = Yii::$app->session['so_luong'];
        $tong_tien = 0;
        $tong_so_luong = 0;

        foreach ($_GET['SoLuong'] as $index => $item){
            $so_luongs[$index] = $item;
            $tong_tien += $item * $_GET['GiaBan'][$index];
            $tong_so_luong += $item;
        }

        Yii::$app->session['tong_san_pham'] = $tong_so_luong;
        Yii::$app->session['so_luong'] =  $so_luongs;
        Yii::$app->session['tong_tien'] = $tong_tien;

        echo Json::encode(['message' => 'Đã cập nhật giỏ hàng']);
    }

    /** thanh-toan */
    public function actionThanhToan(){
        if(Yii::$app->user->isGuest){
            if(isset($_GET['notlogin'])){
                $model = new DonHang();
                if(isset(Yii::$app->session['san_pham'])){
                    $gio_hangs = Yii::$app->session['san_pham'];
                    $so_luongs = Yii::$app->session['so_luong'];
                    $tong_tien = Yii::$app->session['tong_tien'];
                    $tong_so_luong = Yii::$app->session['tong_san_pham'];
                }else{
                    $gio_hangs = [];
                    $so_luongs = [];
                    $tong_tien = 0;
                    $tong_so_luong = 0;
                }
                if ($model->load(Yii::$app->request->post())) {
                    if($model->save()) {
                        // Gửi mail
                        // Đơn hàng <#mã đơn>
                        if(!empty($model->email)) {
                            $chi_tiet_don_hang = $this->renderPartial('_tbl_san_pham_da_dat', [
                                'gio_hangs' => $gio_hangs,
                                'so_luongs' => $so_luongs,
                                'tong_tien' => $tong_tien,
                                'tong_so_luong' => $tong_so_luong,
                            ]);
                            $yiiMailer = new Mailer();
                            $transPort = new \Swift_SmtpTransport('smtp.gmail.com', '465', 'SSL');
                            $transPort->setUsername('thanh75288@st.vimaru.edu.vn');
                            $transPort->setPassword('31299t#P');
                            $yiiMailer->setTransport($transPort);
                            $yiiMailer->compose()->setCharset('utf8')
                                ->setFrom(['thanh75288@st.vimaru.edu.vn' => 'Learning Project'])
                                ->setTo($model->email)
                                ->setHtmlBody($chi_tiet_don_hang)
                                ->setSubject('Chúng tôi đã nhận được đơn hàng #' . $model->id . ' của bạn')->send();
                        }

                        unset(Yii::$app->session['san_pham']);
                        unset(Yii::$app->session['so_luong']);
                        unset(Yii::$app->session['tong_tien']);
                        unset(Yii::$app->session['tong_san_pham']);
                        Yii::$app->session->setFlash('thongbao',"<div class='alert alert-success'> Đã lưu đơn hàng thành công</div>");

                        return $this->redirect(['site/index']);
                    }else{
                        VarDumper::dump(Html::errorSummary($model)); exit;
                    }
                }
//                VarDumper::dump($gio_hangs, 10, true); exit;
                return $this->render('thanh_toan', [
                    'gio_hangs' => $gio_hangs,
                    'so_luongs' => $so_luongs,
                    'tong_tien' => $tong_tien,
                    'tong_so_luong' => $tong_so_luong,
                    'model' => $model
                ]);
            }else {
                $this->redirect(['login']);
            }
        }else{
            $model = new DonHang();
            $user = User::findOne(Yii::$app->user->id);
            $model->ho_ten = $user->ho_ten;
            $model->dien_thoai = $user->dien_thoai;
            $model->email = $user->email;
            $model->dia_chi_giao_hang = $user->dia_chi;
            if(isset(Yii::$app->session['san_pham'])){
                $gio_hangs = Yii::$app->session['san_pham'];
                $so_luongs = Yii::$app->session['so_luong'];
                $tong_tien = Yii::$app->session['tong_tien'];
                $tong_so_luong = Yii::$app->session['tong_san_pham'];
            }else{
                $gio_hangs = [];
                $so_luongs = [];
                $tong_tien = 0;
                $tong_so_luong = 0;
            }
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()) {

                    // Gửi mail
                    // Đơn hàng <#mã đơn>
                    if(!empty($model->email)) {
                        $chi_tiet_don_hang = $this->renderPartial('_tbl_san_pham_da_dat', [
                            'gio_hangs' => $gio_hangs,
                            'so_luongs' => $so_luongs,
                            'tong_tien' => $tong_tien,
                            'tong_so_luong' => $tong_so_luong,
                        ]);
                        $yiiMailer = new Mailer();
                        $transPort = new \Swift_SmtpTransport('smtp.gmail.com', '465', 'SSL');
                        $transPort->setUsername('thanh75288@st.vimaru.edu.vn');
                        $transPort->setPassword('31299t#P');
                        $yiiMailer->setTransport($transPort);
                        $yiiMailer->compose()->setCharset('utf8')
                            ->setFrom(['thanh75288@st.vimaru.edu.vn' => 'Learning Project'])
                            ->setTo($model->email)
                            ->setHtmlBody($chi_tiet_don_hang)
                            ->setSubject('Chúng tôi đã nhận được đơn hàng #' . $model->id . ' của bạn')->send();
                    }

                    unset(Yii::$app->session['san_pham']);
                    unset(Yii::$app->session['so_luong']);
                    unset(Yii::$app->session['tong_tien']);
                    unset(Yii::$app->session['tong_san_pham']);
                    Yii::$app->session->setFlash('thongbao',"<div class='alert alert-success'> Đã lưu đơn hàng thành công</div>");

                    return $this->redirect(['site/index']);
                }else{
                    VarDumper::dump(Html::errorSummary($model)); exit;
                }
            }
            return $this->render('thanh_toan', [
                'gio_hangs' => $gio_hangs,
                'so_luongs' => $so_luongs,
                'tong_tien' => $tong_tien,
                'tong_so_luong' => $tong_so_luong,
                'model' => $model
            ]);
        }
    }

    /** xoa-san-pham */
    public function actionXoaSanPham($id){
        if(isset(Yii::$app->session['san_pham'])){
            $gio_hangs = Yii::$app->session['san_pham'];
            $so_luongs = Yii::$app->session['so_luong'];
            $tong_tien = Yii::$app->session['tong_tien'];
            $tong_so_luong = Yii::$app->session['tong_san_pham'];
        }

        /** @var $san_pham_xoa SanPham */
//        VarDumper::dump($so_luongs, 10, true); exit;
        $so_luong_xoa = $so_luongs[$id];
        $san_pham_xoa = $gio_hangs[$id];
        $tong_so_luong = $tong_so_luong - $so_luong_xoa;
        $tong_tien = $tong_tien - $san_pham_xoa->gia_ban * $so_luong_xoa;

        unset($gio_hangs[$id]);
        unset($so_luongs[$id]);
        Yii::$app->session['tong_tien'] = $tong_tien;
        Yii::$app->session['tong_san_pham'] = $tong_so_luong;
        Yii::$app->session['san_pham'] = $gio_hangs;
        Yii::$app->session['so_luong'] = $so_luongs;
        Yii::$app->session->setFlash('thongbao', '<div class="alert alert-success"> Đã xóa sản phẩm khỏi giỏ hàng</div>');
        if(empty($tong_tien)){
            $this->redirect(['site/index']);
        }else{
            $this->redirect(['site/gio-hang']);
        }
    }

    /** user */
    public function actionUser(){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }
        $model = User::findOne(Yii::$app->user->id);
        $old_password = $model->password_hash;
        if ($model->load(Yii::$app->request->post())) {
            if($old_password != $model->password_hash){
                $new_password = Yii::$app->security->generatePasswordHash($model->password_hash);
            }else{
                $new_password = $old_password;
            }
            User::updateAll([
                'ho_ten' => $model->ho_ten,
                'username' => $model->username,
                'email' => $model->email,
                'dien_thoai' => $model->dien_thoai,
                'dia_chi' => $model->dia_chi,
                'updated_at' => date("Y-m-d H:i:s"),
                'password_hash' => $new_password,
            ], ['id' => $model->id]);
        }
        return $this->render('user', ['model' => $model]);
    }

    /** timkiem */
    public function actionTimkiem(){
        if(isset($_POST['search'])){
            $ket_qua = QuanLySanPham::find()->andFilterWhere(['like', 'name', $_POST['search']])
                ->orFilterWhere(['like', 'nhom_san_pham', $_POST['search']])
                ->orFilterWhere(['like', 'ten_thuong_hieu', $_POST['search']])->all();
        }
        return $this->render('tim_kiem', ['ket_qua' => $ket_qua]);
    }
}

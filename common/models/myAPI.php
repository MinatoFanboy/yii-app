<?php

namespace common\models;

use Yii;
use kartik\mpdf\Pdf;
use yii\helpers\Json;
use yii\db\Expression;
use yii\bootstrap\Html;
use yii\jui\DatePicker;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;
use yii\swiftmailer\Mailer;

class myAPI
{
    const ACTIVE = 1;
    const IN_ACTIVE = 0;

    public static function createCode($str)
    {
        $str = trim($str);
        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ"
            , "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", "ê", "ù", "à");
        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", "e", "u", "a");
        $str = str_replace($coDau, $khongDau, $str);
        $str = trim(preg_replace("/\\s+/", " ", $str));
        $str = preg_replace("/[^a-zA-Z0-9 \-.]/", "", $str);
        $str = strtolower($str);
        return str_replace(" ", '-', $str);
    }

    public static function createEngName($str)
    {
        $str = trim($str);
        $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ"
            , "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ",
            "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
            , "ờ", "ớ", "ợ", "ở", "ỡ",
            "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
            "ỳ", "ý", "ỵ", "ỷ", "ỹ",
            "đ",
            "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
            , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
            "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
            "Ì", "Í", "Ị", "Ỉ", "Ĩ",
            "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
            , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
            "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
            "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
            "Đ", "ê", "ù", "à");
        $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
            , "a", "a", "a", "a", "a", "a",
            "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
            "i", "i", "i", "i", "i",
            "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o"
            , "o", "o", "o", "o", "o",
            "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
            "y", "y", "y", "y", "y",
            "d",
            "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A"
            , "A", "A", "A", "A", "A",
            "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
            "I", "I", "I", "I", "I",
            "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O"
            , "O", "O", "O", "O", "O",
            "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
            "Y", "Y", "Y", "Y", "Y",
            "D", "e", "u", "a");
        $str = str_replace($coDau, $khongDau, $str);
        $str = trim(preg_replace("/\\s+/", " ", $str));
        $str = preg_replace("/[^a-zA-Z0-9 \-.]/", "", $str);
        $str = strtoupper($str);
        return $str;
    }

    public static function getNam($namBatDau, $namKetThuc)
    {
        $namBatDau = (int) $namBatDau;
        $namKetThuc = (int) $namKetThuc;
        for ($i = $namBatDau; $i <= $namKetThuc; $i++) {
            $data[$i] = $i;
        }
        return $data;
    }

    public static function getMessage($att, $content)
    {
        return "<div class='note note-{$att}'>{$content}</div>";
    }

    public static function createMessage($att, $content)
    {
        return [
            'messagePlan' => $content,
            'messageHtml' => self::getMessage($att, $content),
        ];
    }

    public static function getHeadModal($noidung)
    {
        return '<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">' . $noidung . '</h4>';
    }

    public static function activeDateField($form, $model, $field, $label, $options = ['class' => 'form-control', 'autocomplete' => 'off'])
    {
        return $form->field($model, $field)->widget(DatePicker::className(), [
            'language' => 'vi',
            'dateFormat' => 'dd/MM/yyyy',
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => (date('Y') - 50) . ':' . (date('Y') + 1),
                'changeYear' => true,
            ],
            'options' => $options,
        ])->label($label);
    }

    public static function activeDateField2($form, $model, $field, $label, $options = ['class' => 'form-control'])
    {
        return $form->field($model, $field)->widget(DatePicker::className(), [
            'language' => 'vi',
            'dateFormat' => 'dd/MM/yyyy',
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => (date('Y') - 10) . ':' . (date('Y') + 1),
                'changeYear' => true,
            ],
            'options' => $options,
        ])->label($label);
    }

    public static function dateField($name, $value, $options = ['form-control'])
    {
        return DatePicker::widget([
            'language' => 'vi',
            'dateFormat' => 'dd/MM/yyyy',
            'name' => $name,
            'value' => $value,
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => (date('Y') - 50) . ':' . (date('Y') + 1),
                'changeYear' => true,
            ],
            'options' => $options,
        ]);
    }

    public static function dateField2($name, $value, $options = ['class' => 'form-control'])
    {
        return DatePicker::widget([
            'language' => 'vi',
            'dateFormat' => 'dd/MM/yyyy',
            'name' => $name,
            'value' => $value,
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => (date('Y') - 10) . ':' . (date('Y') + 1),
                'changeYear' => true,
            ],
            'options' => $options,
        ]);
    }

    public static function activeDateFieldNoLabel($model, $attribute, $options = ['class' => 'form-control'])
    {
        return DatePicker::widget([
            'language' => 'vi',
            'model' => $model,
            'dateFormat' => 'dd/MM/yyyy',
            'attribute' => $attribute,
            'clientOptions' => [
                'changeMonth' => true,
                'yearRange' => (date('Y') - 10) . ':' . (date('Y') + 1),
                'changeYear' => true,
            ],
            'options' => $options,
        ]);
    }

    public static function convertDateSaveIntoDb($date)
    {
        if ($date == "") {
            return null;
        }

        $splash = '/';
        if (strpos($date, '-') !== false) {
            $splash = '-';
        } else if (strpos($date, '.') !== false) {
            $splash = '.';
        }

        $date = trim($date);
        if ($date == "") {
            return new Expression('NULL');
        }
        $arr = explode(trim($splash), $date);
        if (count($arr) == 3) {
            return implode('-', array_reverse($arr));
        } else if (count($arr) == 2) {
            return date("Y") . "-{$arr[1]}-{$arr[0]}";
        } else {
            return date("Y") . "-" . date("m") . "-" . $arr[0];
        }
    }

    public static function getBtnCloseModal()
    {
        return Html::button('<i class="fas fa-times"></i> Đóng lại', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]);
    }

    public static function getBtnFooter($label, $options = [])
    {
        return Html::button($label, $options);
    }

    public static function getAFieldOfAModelFromName($model, $field, $name)
    {
        $code = self::createCode(trim($name));
        $data = $model->find()->where(['code' => $code])->one();
        if (is_null($data)) {
            return '';
        }

        return $data->{$field};
    }

    public static function getFilterFromTo($searchModel, $fieldFrom, $field_to, $options = ['class' => 'form-control'])
    {
        return Html::activeTextInput($searchModel, $fieldFrom, $options) .
        Html::activeTextInput($searchModel, $field_to, $options);
    }

    public static function getBtnSearch()
    {
        return '<button type="button" class="btn btn-primary btn-search"><i class="fas fa-search"></i> Tìm kiếm</button>';
    }

    public static function getDMY($YMD)
    {
        if ($YMD != "") {
            return date("d/m/Y", strtotime($YMD));
        }

        return '';
    }

    public static function getBtnDownload()
    {
        return Html::button('<i class="fa fa-cloud-download"></i> Tải xuống', ['class' => 'btn btn-primary btn-download pull-right']);
    }

    public static function getBtnDeleteAjaxCRUD($text, $url, $clsBtn = '')
    {
        return Html::a('<i class="fa fa-trash"></i> ' . $text, $url, ['title' => 'Xóa', 'role' => 'modal-remote', 'data-request-method' => 'post', 'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Thông báo', 'data-confirm-message' => 'Bạn có chắc chắn muốn xóa không ?', 'class' => $clsBtn]);
    }

    public static function getDsThang()
    {
        $arr = [];
        for ($i = 1; $i <= 12; $i++) {
            $arr[$i] = "Tháng {$i}";
        }

        return $arr;
    }

    public static function createUpdateBtnInGrid($path, $title = 'Sửa dữ liệu')
    {
        return Html::a('<i class="fa fa-edit"></i>', $path, ['title' => $title, 'data-pjax' => 0, 'role' => 'modal-remote', 'data-toggle' => 'tooltip', 'data-original-tile' => $title]);
    }

    public static function createDeleteBtnInGrid($path, $title = 'Hủy dữ liệu')
    {
        return Html::a('<i class="fa fa-trash"></i>', $path, ['title' => $title, 'data-pjax' => 0, 'role' => 'modal-remote', 'data-request-method' => 'post', 'data-toggle' => 'tooltip', 'data-confirm-title' => 'Thông báo', 'data-confirm-message' => 'Bạn có chắc chắn muốn hủy dữ liệu này?', 'data-original-title' => 'Hủy', 'class' => 'text-danger']);
    }

    public static function getBtnDeletInRow($model, $id, $optionsTD = ['class' => 'text-center'])
    {
        return Html::tag('td', Html::a('<i class="fa fa-trash"></i>', '#', ['class' => 'text-danger btn-xoa-dong-tren-bang', 'id' => "{$model}-{$id}"]), $optionsTD);
    }

    public static function getBtnDeletInRowNewRow($options = ['class' => "text-center"])
    {
        return Html::tag('td', Html::a('<i class="fa fa-trash"></i>', '#', ['class' => 'text-danger btn-xoa-dong-tren-bang dong-moi-trenbang']), $options);
    }

    public static function getRowBoSung($id, $colspan)
    {
        return Html::tag('tr', Html::tag('td', Html::button('<i class="fa fa-plus"></i> Bổ sung', [
            'class' => 'btn btn-sm btn-primary btn-them-dong-moi',
            'id' => $id,
        ]), ['colspan' => $colspan]));
    }

    public static function saveAnExistTable($post, $model, $attributes = [])
    {
        if (isset($_POST[$post])) {
            foreach ($_POST[$post] as $id => $item) {
                $kqkd = $model->findOne($id);
                $kqkd->attributes = $item;
                foreach ($attributes as $attribute => $value) {
                    $kqkd->{$attribute} = $value;
                }
                if (!$kqkd->save()) {
                    var_dump(Html::errorSummary($kqkd));
                    exit;
                }
            }
        }
    }

    public static function saveOtherTable($newOBJ, $firstField, $objectName, $others = [])
    {
        $model = new $objectName();
        $arr_fields = $model->attributes;
        if (isset($_POST[$newOBJ][$firstField])) {
            foreach ($_POST[$newOBJ][$firstField] as $index => $item) {
                /** @var  $newModel ActiveRecord*/
                $newModel = new $objectName();
                foreach ($arr_fields as $field => $value) {
                    if (isset($_POST[$newOBJ][$field][$index])) {
                        $newModel->{$field} = $_POST[$newOBJ][$field][$index];
                    }

                }
                foreach ($others as $field => $value) {
                    $newModel->{$field} = $value;
                }
                if (!$newModel->save()) {var_dump(Html::errorSummary($newModel));exit();};
            }
        }
    }

    public static function isAccess($arrRoles)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        /** @var User $user_logged_in */
        $user_logged_in = Yii::$app->user->identity;
        if ($user_logged_in->id == 1) {
            return true;
        }

        return in_array($user_logged_in->vai_tro, $arrRoles);
    }

    public static function isHasRole($name)
    {
        $vaitro = Role::findOne(['name' => $name]);
        if (is_null($vaitro)) {
            return false;
        }

        return !is_null(UserRole::findOne(['role_id' => $vaitro->id, 'user_id' => Yii::$app->user->identity->ID]));
    }

    public static function sendMai($to, $subject, $message, $username, $password, $fromName, $pathFiles = [], $host = 'smtp.gmail.com', $port = '587', $ecryption = 'tls')
    {
        $mailer = new Mailer();
        $mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => $host,
            'username' => $username,
            'password' => $password,
            'port' => $port,
            'encryption' => $ecryption,
        ]);

        $mail = $mailer->compose()
            ->setFrom([$username => $fromName])
            ->setTo($to);

        foreach ($pathFiles as $pathFile) {
            $mail->attach($pathFile);
        }

        return $mail
            ->setHtmlBody($message)
            ->setSubject($subject)
            ->setCharset('UTF-8')
            ->send();
    }

    public static function getYMDFromDMY($date, $splash = '-')
    {
        if ($date == '') {
            return '';
        }

        $arr = explode($splash, $date);
        return implode('-', array_reverse($arr));
    }

    public static function getCodesMBLDaChon()
    {
        $arr = [];
        if (\Yii::$app->session->get('ma')) {
            $arr = \Yii::$app->session->get('ma');
        }

        if (count($arr) > 0) {
            return 'Học viên đã chọn: ' . implode(', ', $arr);
        }

        return '';
    }

    public static function isAccess2($controller, $action)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        } else {
            if (Yii::$app->user->identity->getId() == 1) {
                return true;
            }

            $action = ucfirst($action);
            $controller_action = "{$controller};{$action}";
            $user_id = Yii::$app->user->id;
            return !is_null(QuanLyPhanQuyen::findOne(['controller_action' => $controller_action, 'user_id' => $user_id]));
        }
    }

    public static function convertDMY2YMD($strDate)
    {
        $arr = explode('/', $strDate);
        return implode('-', array_reverse($arr));
    }

    public static function covertYMD2DMY($strDate)
    {
        if ($strDate == '') {
            return '';
        }

        return date("d/m/Y", strtotime($strDate));
    }

    public static function covertYMD2TDMY($strDate)
    {
        $arr = explode(' ', $strDate);
        $arrT = $arr[1];
        $arrPD = explode('-', $arr[0]);

        $arrD = implode('-', array_reverse($arrPD));
        $time = $arrD . ' ' . $arrT;
        return $time;
    }

    public static function covertTDMY2YMD($strDate)
    {

        if (strpos(':', $strDate) > 0) {
            $arr = explode(' ', $strDate);
            $arrT = $arr[0];
            $arrPD = explode('-', $arr[1]);
            $arrD = implode('-', array_reverse($arrPD));
            $time = $arrD . ' ' . $arrT;
            return $time;
        } else {
            $arr = explode('-', $strDate);
        }

        $time = implode('-', array_reverse($arr));
        return $time;

    }

    public static function get_extension_image($imagetype)
    {
        if (empty($imagetype)) {
            return false;
        }

        switch ($imagetype) {
            case 'image/bmp':return '.bmp';
            case 'image/cis-cod':return '.cod';
            case 'image/gif':return '.gif';
            case 'image/ief':return '.ief';
            case 'image/jpeg':return '.jpg';
            case 'image/pipeg':return '.jfif';
            case 'image/tiff':return '.tif';
            case 'image/x-cmu-raster':return '.ras';
            case 'image/x-cmx':return '.cmx';
            case 'image/x-icon':return '.ico';
            case 'image/x-portable-anymap':return '.pnm';
            case 'image/x-portable-bitmap':return '.pbm';
            case 'image/x-portable-graymap':return '.pgm';
            case 'image/x-portable-pixmap':return '.ppm';
            case 'image/x-rgb':return '.rgb';
            case 'image/x-xbitmap':return '.xbm';
            case 'image/x-xpixmap':return '.xpm';
            case 'image/x-xwindowdump':return '.xwd';
            case 'image/png':return '.png';
            case 'image/x-jps':return '.jps';
            case 'image/x-freehand':return '.fh';
            default:return false;
        }
    }

    public static function get_extension($name)
    {
        if (empty($imagetype)) {
            return false;
        } else {
            $array = explode('.', $name);
            return end($array);
        }
    }

    public static function tinhSoNgay($dt1, $dt2)
    {
        $t1 = strtotime($dt1);
        $t2 = strtotime($dt2);

        $dtd = new \stdClass();
        $dtd->interval = $t2 - $t1;
        $dtd->total_sec = abs($t2 - $t1);
        $dtd->total_min = floor($dtd->total_sec / 60);
        $dtd->total_hour = floor($dtd->total_min / 60);
        $dtd->total_day = floor($dtd->total_hour / 24);

        $dtd->day = $dtd->total_day;
        $dtd->hour = $dtd->total_hour - ($dtd->total_day * 24);
        $dtd->min = $dtd->total_min - ($dtd->total_hour * 60);
        $dtd->sec = $dtd->total_sec - ($dtd->total_min * 60);
        return $dtd->total_day;
    }

    public static function getQuy($thang)
    {
        $arr_quy = [
            1 => 'Quý I',
            2 => 'Quý I',
            3 => 'Quý I',
            4 => 'Quý II',
            5 => 'Quý II',
            6 => 'Quý II',
            7 => 'Quý III',
            8 => 'Quý III',
            9 => 'Quý III',
            10 => 'Quý IV',
            11 => 'Quý IV',
            12 => 'Quý IV',
        ];
        return $arr_quy[$thang];
    }

    public static function sendMailGun($content, $from, $to, $subject)
    {
        \Yii::$app->mailer->compose('contact/html', ['contactForm' => $content])
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }

    public static function sendMailAmzon($content, $form, $to, $subject)
    {
        \Yii::$app->mail->compose('contact/html', ['contactForm' => $content])
            ->setFrom([$form => 'QUAN LY CONG VIEC'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }

    public static function pushNotification($content, $ids)
    {
        \Yii::$app->webpusher->userPush($content, $ids);
    }

    public static function getRangeMonthsByQuy($name, $nam)
    {
        $quy = [
            'quy-i' => [
                'from' => mktime(0, 0, 0, 1, 1, $nam),
                'to' => mktime(0, 0, 0, 3, 31, $nam),
            ],
            'quy-ii' => [
                'from' => mktime(0, 0, 0, 4, 1, $nam),
                'to' => mktime(0, 0, 0, 6, 30, $nam),
            ],
            'quy-iii' => [
                'from' => mktime(0, 0, 0, 7, 1, $nam),
                'to' => mktime(0, 0, 0, 9, 30, $nam),
            ],
            'quy-iv' => [
                'from' => mktime(0, 0, 0, 10, 1, $nam),
                'to' => mktime(0, 0, 0, 12, 31, $nam),
            ],
        ];
        return $quy[$name];
    }

    public static function exportPDF($content, $file_name, $title, $subject, $header, $footer, $margin, $temPath, $urlTaiFile)
    {
        $pdf = new \kartik\mpdf\Pdf([
            'mode' => \kartik\mpdf\Pdf::MODE_UTF8, // leaner size using standard fonts
            'content' => $content,
            'filename' => $file_name,
            'orientation' => Pdf::ORIENT_LANDSCAPE,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}
                        body{font-family: "Times"; font-size: 8pt} table td,table th{padding: 5px}',
            'options' => [
                'title' => $title,
                'subject' => $subject,
            ],
            'methods' => [
                'SetHeader' => [$header],
                'SetFooter' => [$footer],
            ],
            'destination' => Pdf::DEST_FILE,
            'marginLeft' => $margin[1],
            'marginRight' => $margin[3],
            'marginTop' => $margin[0],
            'marginBottom' => $margin[2],
            'tempPath' => $temPath,
        ]);

        $pdf->render();
        echo Json::encode([
            'title' => 'Tải file kết quả',
            'content' => \yii\helpers\Html::a('<i class="fa fa-cloud-download"></i> Nhấn vào đây để tải file về!', $urlTaiFile, ['class' => 'text-primary', 'target' => '_blank']),
        ]);
    }

    public static function roundUpToAny($n, $x)
    {
        return (round($n) % $x === 0) ? round($n) : round(($n + $x / 2) / $x) * $x;
    }

    public static function br2newline($input)
    {
        $out = str_replace("<br>", "\n", $input);
        $out = str_replace("<br/>", "\n", $out);
        $out = str_replace("<br />", "\n", $out);
        $out = str_replace("<BR>", "\n", $out);
        $out = str_replace("<BR/>", "\n", $out);
        $out = str_replace("<BR />", "\n", $out);
        return $out;
    }

    public static function sum_time($time)
    {
        $hours = 0;
        $min = 0;
        $sec = 0;
        foreach ($time as $time_array) {
            $time_exp = explode(':', $time_array);
            $hours = $hours + $time_exp[0];
            $min = $min + $time_exp[1];
            $sec = $sec + $time_exp[2];
        }
        while ($sec >= 60) {
            $sec = $sec - 60;
            $min++;
        }
        while ($min >= 60) {
            $min = $min - 60;
            $hours++;
        }
        $time_output = '';
        $time_output = $hours . ':' . $min . ':' . $sec;
        return $time_output;
    }

    public static function getUserIP2()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

    public static function does_url_exists($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code == 200) {
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);
        return $status;
    }

    public static function conver_arr_to_obj($arr)
    {
        $obj = json_decode(json_encode($arr), false);
        return $obj;
    }

    public static function VndText($amount)
    {
        if ($amount <= 0) {
            return $textnumber = "Tiền phải là số nguyên dương lớn hơn số 0";
        }
        $Text = array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $TextLuythua = array("", "nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
        $textnumber = "";
        $length = strlen($amount);

        for ($i = 0; $i < $length; $i++) {
            $unread[$i] = 0;
        }

        for ($i = 0; $i < $length; $i++) {
            $so = substr($amount, $length - $i - 1, 1);

            if (($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)) {
                for ($j = $i + 1; $j < $length; $j++) {
                    $so1 = substr($amount, $length - $j - 1, 1);
                    if ($so1 != 0) {
                        break;
                    }

                }

                if (intval(($j - $i) / 3) > 0) {
                    for ($k = $i; $k < intval(($j - $i) / 3) * 3 + $i; $k++) {
                        $unread[$k] = 1;
                    }

                }
            }
        }

        for ($i = 0; $i < $length; $i++) {
            $so = substr($amount, $length - $i - 1, 1);
            if ($unread[$i] == 1) {
                continue;
            }

            if (($i % 3 == 0) && ($i > 0)) {
                $textnumber = $TextLuythua[$i / 3] . " " . $textnumber;
            }

            if ($i % 3 == 2) {
                $textnumber = 'trăm ' . $textnumber;
            }

            if ($i % 3 == 1) {
                $textnumber = 'mươi ' . $textnumber;
            }

            $textnumber = $Text[$so] . " " . $textnumber;
        }

        //Phai de cac ham replace theo dung thu tu nhu the nay
        $textnumber = str_replace("không mươi", "lẻ", $textnumber);
        $textnumber = str_replace("lẻ không", "", $textnumber);
        $textnumber = str_replace("mươi không", "mươi", $textnumber);
        $textnumber = str_replace("một mươi", "mười", $textnumber);
        $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
        $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
        $textnumber = str_replace("mười năm", "mười lăm", $textnumber);

        return ucfirst($textnumber . " đồng chẵn");
    }

    public static function compareDecimal($num1, $num2)
    {
        $epsilon = 0.00001;
        return abs($num1 - $num2) < $epsilon;
    }

    public static function convertIOSDate($date)
    {
        $dt = new \DateTime($date);
        return $dt->format('Y-m-d\TH:i:s.') . substr($dt->format('u'), 0, 3) . 'Z';
    }

    public function ip_info() {        
        $ip = file_get_contents("http://ipecho.net/plain"); // the IP address to query
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if($query && $query['status'] == 'success') {
            $ip = $query['country'];
        } else {
            $ip = null;
        }
    }
}

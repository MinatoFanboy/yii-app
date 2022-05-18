<?php

namespace common\models\exports;

use common\models\formatExcel;
use common\models\User;
use PhpOffice\PhpSpreadsheet\Calculation\DateTime;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use yii\web\HttpException;

class exportUser
{
    public $data;
    public $path;
    public $file_name;

    public function renderBody($activeSheet){
        $users = $this->data;

        $row = 5;
        $activeSheet->setCellValue('A2', 'Cập nhật đến ngày: '.date('d/m/Y H:i:s'));
        foreach ($users as $index => $user){
            /**
             * @var $user User
             */
            $activeSheet->setCellValue("A{$row}", $index + 1)
                ->setCellValue("B{$row}", $user->username)
                ->setCellValue("C{$row}", $user->email)
                ->setCellValue("D{$row}", $user->created_at ? DateTime::getDateValue($user->created_at) : '');
            $row++;
        }

        $row--;
        formatExcel::setBorder($activeSheet, "A5:D{$row}");
        // formatExcel::setColor($activeSheet, "A5:D{$row}", 'FFF');
    }

    public function init(){
        $spreadsheet = IOFactory::load(dirname(dirname(__DIR__)).'/template/EXAMPLE_USER.xlsx');
        $activeSheet = $spreadsheet->getActiveSheet();
        $this->renderBody($activeSheet);
        $activeSheet->setTitle('Danh sách người dùng');
        $this->file_name = 'NGUOI_DUNG.xlsx';;
        $this->path.= $this->file_name;

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');

        header('Cache-Control: max-age=1');

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        try {
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($this->path);
            return $this->file_name;
        } catch (Exception $e) {
            throw new HttpException(500, $e);
        }
    }
}

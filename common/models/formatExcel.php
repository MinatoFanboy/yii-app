<?php

namespace common\models;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class formatExcel
{
    /**
     * @param $activeSheet Worksheet
     */
    public static function setFontBold($activeSheet, $range){
        $activeSheet->getStyle($range)
            ->applyFromArray([
                'font' => [
                    'bold' => true
                ]
            ]);

    }

    public static function setFontNoneBold($activeSheet, $range){
        $activeSheet->getStyle($range)
            ->applyFromArray([
                'font' => [
                    'bold' => false
                ]
            ]);

    }

    /**
     * @param $activeSheet Worksheet
     */
    public static function alignCenterText($activeSheet, $range){
        $activeSheet->getStyle($range)->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER)
        );
    }

    public static function alignMiddleText($activeSheet, $range){
        $activeSheet->getStyle($range)->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER)
        );
    }

    /**
     * @param $activeSheet Worksheet
     */
    public static function alignLeftText($activeSheet, $range){
        $activeSheet->getStyle($range)->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_LEFT,)
        );
    }


    public static function alignRightText($activeSheet, $range){
        $activeSheet->getStyle($range)->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_RIGHT,)
        );
    }

    /**
     * @param $activeSheet Worksheet
     * @param $columnStart string
     * @param $columnEnd string
     */
    public static function setAutoWidthColumnd($activeSheet, $columnStart = 'A', $columnEnd = 'Z'){
        foreach(range($columnStart,$columnEnd) as $columnID)
        {
            $activeSheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    }

    /**
     * @param $activeSheet Worksheet
     * @param $columnStart string
     * @param $columnEnd string
     * @param $width int
     */
    public static function setWidthColumn($activeSheet, $columnStart = 'A', $columnEnd = 'A', $width = -1){
        foreach(range($columnStart,$columnEnd) as $columnID)
        {
            $activeSheet->getColumnDimension($columnID)->setWidth($width);
        }
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range string
     */
    public static function setWrapText($activeSheet, $range){
        $activeSheet->getStyle($range)->getAlignment()->setWrapText(true);
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range string
     */
    public static function alignVerticalCenter($activeSheet, $range){
        $activeSheet->getStyle($range)->getAlignment()->applyFromArray(
            array('vertical' => Alignment::VERTICAL_CENTER,)
        );
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range string
     */
    public static function alignHorizontalLeft($activeSheet, $range){
        $activeSheet->getStyle($range)->getAlignment()->applyFromArray(
            array('horizontal' => Alignment::HORIZONTAL_LEFT)
        );
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range string
     */
    public static function setFontSize($activeSheet, $range, $size){
        $activeSheet->getStyle($range)->applyFromArray([
            'font' => [
                'size' => $size
            ]
        ]);
    }

    public static function setHeightRow($activeSheet, $row, $height = 40){
        $activeSheet->getRowDimension($row)->setRowHeight($height);
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range string
     */
    public static function setBorder($activeSheet, $range){
        $activeSheet->getStyle($range)->applyFromArray([
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => Border::BORDER_THIN
                )
            )
        ]);
    }

    public static function setNoneBorder($activeSheet, $range){
        $activeSheet->getStyle($range)->applyFromArray([
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => Border::BORDER_NONE
                )
            )
        ]);
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range
     * @param int $fontSize
     * @param string $fontFamily
     */
    public static function setFontFamily($activeSheet, $range, $fontSize = 12, $fontFamily='Times New Roman'){
        $activeSheet->getStyle($range)->getFont()->setName($fontFamily)->setSize($fontSize);
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range
     * @param $colorRGB
     */
    public static function setBgColor($activeSheet, $range, $colorRGB){
        $activeSheet
            ->getStyle($range)->getFill()->applyFromArray(array(
                'type' =>  Fill::FILL_SOLID,
                'startcolor' => array(
                    'rgb' => $colorRGB
                )
            ));
    }

    public static function setColor($activeSheet, $range, $colorRGB){
        $activeSheet->getStyle($range)->applyFromArray(
            array(
                'fill' => array(
                    'type' => Fill::FILL_SOLID,
                    'color' => array('rgb' => $colorRGB)
                )
            )
        );
    }

    /**
     * @param $activeSheet Worksheet
     * @param $range string
     * @param $format string
     */
    public static function setFormatCell($activeSheet, $range, $format){
        $activeSheet->getStyle($range)->getNumberFormat()->setFormatCode($format);
    }
}

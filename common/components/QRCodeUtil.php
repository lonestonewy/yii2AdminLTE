<?php
namespace common\components;

use Yii;
use dosamigos\qrcode\QrCode;
use dosamigos\qrcode\lib\Enum;

class QRCodeUtil
{
    public static function make($url, $logo = null, $size=7)
    {
        if($url){
            $tmp_filename = Yii::getAlias('@runtime/'.time().rand(1000,9999).'.png');
            QrCode::png($url, $tmp_filename, Enum::QR_ECLEVEL_H, $size, 0);
            $QR = imagecreatefromstring(file_get_contents($tmp_filename));
            if($logo){
                $logo_filename= Yii::getAlias('@webroot'.$logo);
                if(file_exists($logo_filename)){
                    $logo = imagecreatefromstring(file_get_contents($logo_filename));
                    $QR_width = imagesx($QR);//二维码图片宽度
                    $QR_height = imagesy($QR);//二维码图片高度
                    $logo_width = imagesx($logo);//logo图片宽度
                    $logo_height = imagesy($logo);//logo图片高度
                    $logo_qr_width = $QR_width / 4;
                    $scale = $logo_width/$logo_qr_width;
                    $logo_qr_height = $logo_height/$scale;
                    $from_width = ($QR_width - $logo_qr_width) / 2;
                    //重新组合图片并调整大小
                    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
                }
            }
            imagepng($QR);
            unlink($tmp_filename);
        }
    }
}
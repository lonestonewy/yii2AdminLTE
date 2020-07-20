<?php
namespace api\components;

use common\behaviors\FileModel;
use common\models\Resource;
use xr0m3oz\simplehtml\SimpleHtmlDom;
use Yii;
use yii\base\UserException as Exception;
use yii\helpers\FileHelper;

class Util
{
    //校验验签
    public static function checkSign($url, $params ,$sign) {
        ksort($params);
        $str = '';
        foreach($params as $key=>$value){
            $str .= $key.'='.$value.'&';
        }
        $str = rtrim($str,'&');
        $url = urlencode($url.'?'.$str);
        return md5($url) === $sign;
    }

    public static function saveBase64Image($base64Data)
    {
        //data:image/jpeg;base64,...
        $pattern = '/data:(.+?)\/(.+?);base64,(.+$)/is';
        $matches = array();

        if(preg_match($pattern, $base64Data, $matches))
        {
            try{
                if($matches[1] != 'image')
                    throw new Exception("必须是图片格式");

                if(!in_array($matches[2], array('gif', 'jpg', 'jpeg', 'png')))
                    throw new Exception("图片格式不正确");

                $fileType = $matches[1].'/'.$matches[2];
                $fileData = base64_decode($matches[3]);
                $fileName = time().rand(1000,9999).'.'.$matches[2];

                $tmpDir = '/upload/image/'.date('Ym');
                $dir = Yii::getAlias('@webroot').$tmpDir;

                if(!file_exists($dir))
                    FileHelper::createDirectory($dir);

                $path = $tmpDir.'/'.$fileName;
                $file = $dir.'/'.$fileName;

                file_put_contents($file, $fileData);

                return $path;
            }
            catch(Exception $e)
            {
            }
        }
        return null;
    }
}
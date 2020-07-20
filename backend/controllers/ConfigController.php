<?php

namespace backend\controllers;

use AlibabaCloud\Client\AlibabaCloud;
use backend\components\Controller;
use OSS\Model\CorsConfig;
use OSS\Model\CorsRule;
use OSS\OssClient;
use Yii;
use yii\base\UserException;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\validators\ImageValidator;
use yii\web\Response;
use yii\web\UploadedFile;

class ConfigController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            unset($post[Yii::$app->request->csrfParam]);
            foreach ($post as $key => $val) {
                Yii::$app->config->set(Yii::$app->session['config']['id'], $key, $val);
            }

            $fileAttributes = ['poster_default_tpl', 'app_icon'];
            $validator = new ImageValidator(['skipOnEmpty' => true, 'extensions' => ['jpg', 'png'], 'maxSize' => 1024 * 1024, 'tooBig' => '图片文件体积过大，不能超过{formattedLimit}.']);
            foreach ($fileAttributes as $name) {
                $file = UploadedFile::getInstanceByName($name);
                if ($file !== null) {
                    if ($validator->validate($file, $error)) {
                        $filename = time() . rand(1000, 9999) . '.' . $file->getExtension();

                        $dir = '/upload/config/' . $name . '/' . date('Ym') . '/';
                        if (!file_exists(Yii::getAlias('@webroot') . $dir)) {
                            FileHelper::createDirectory(Yii::getAlias('@webroot') . $dir);
                        }

                        $filepath = '@webroot' . $dir . $filename;
                        $filepath = Yii::getAlias($filepath);
                        if ($file->saveAs($filepath)) {
                            Yii::$app->config->set(Yii::$app->session['config']['id'], $name, $dir . $filename);
                        }
                    }
                }
            }
            Yii::$app->cache->flush();

            Yii::$app->getSession()->setFlash('success', '操作成功！');
            return $this->redirect(['index']);
        }

        $config = Yii::$app->config->getAll(Yii::$app->session['config']['id']);

        return $this->render('index', [
            'config' => $config,
        ]);
    }

    
}

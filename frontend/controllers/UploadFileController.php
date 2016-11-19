<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/25
 * Time: 19:15
 */

namespace frontend\controllers;


use common\services\FileUploaderService;

class UploadFileController extends BaseController
{
    //
    public $enableCsrfValidation = false;

    /**
     * @ajax
     * @return bool
     */
    public function actionStationPicture()
    {
        // TODO: convert?
        $fileName = FileUploaderService::getUploadFileName();

        $fileName = FileUploaderService::convertFileName($fileName, "{unix_timestamp}_{md5}.{ext}");
        $targetPath = 'stations';

        $result = FileUploaderService::upload($fileName, $targetPath);

        return parent::result(['result' => $result]);
    }
}
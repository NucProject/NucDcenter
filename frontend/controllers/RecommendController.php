<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2017/3/14
 * Time: 20:50
 */

namespace frontend\controllers;


use common\models\KxRecommend;
use common\services\FileUploaderService;

class RecommendController extends BaseController
{
    //
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $recommends = KxRecommend::find(['status' => 1])->asArray()->orderBy('update_time desc')->all();
        return parent::result(['recommends' => $recommends]);
    }

    public function actionAdd()
    {
        $title = \Yii::$app->request->get('title', null);
        $desc = \Yii::$app->request->get('desc', '');
        $image = \Yii::$app->request->get('image', null);
        if (!$title || !$image)
        {
            return parent::error([
                'msg' => 'Bad arguments'
            ], -1);
        }

        $recommend = new KxRecommend();

        $recommend->recommend_title = $title;
        $recommend->recommend_desc = $desc;
        $recommend->recommend_image = $image;

        if ($recommend->save()) {
            return parent::result(['recommend' => $recommend->toArray()]);
        }

    }



    /**
     * @ajax
     * @return bool
     */
    public function actionImage()
    {
        $fileName = FileUploaderService::getUploadFileName();

        $fileName = FileUploaderService::convertFileName($fileName, "{unix_timestamp}_{md5}.{ext}");
        $targetPath = 'demo';

        $result = FileUploaderService::upload($fileName, $targetPath);

        return parent::result(['result' => $result]);
    }
}
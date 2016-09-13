<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/27
 * Time: 12:35
 */

namespace console\controllers;

use yii;
use yii\console\Controller;
use common\components\Cache;

/**
 * Class RecordController
 * @package console\controllers
 */
class RecordController extends Controller
{
    /**
     *
     * 从Redis拿数据转储到MySQL中
     */
    public function actionLanding()
    {
        while (true)
        {

            // 5sec 一次同步
            sleep(5);
        }
    }

    /**
     *
     * 从Redis拿数据转储到MySQL中
     */
    public function actionTest()
    {


    }

    /**
     * @param $deviceKey
     * @return array
     */
    private function fetchNewEntryFromRedis($deviceKey)
    {
        $newEntry = [];
        return $newEntry;
    }

    private function recordEntry($deviceKey, $newEntry)
    {
        return true;
    }


}
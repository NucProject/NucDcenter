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
 *          暂时还没有用到，现在的策略是直接进入MySQL
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

}
<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/20
 * Time: 23:34
 */

namespace console\controllers;

use common\services\DeviceDataService;
use yii\console\Controller;
use yii\db\Migration;

class DatabaseController extends Controller
{

    /**
     * @param $tableName
     * @param string $primaryKey
     * Only support MySQL now.
     * 提供一个符合该项目数据库设计标准的基本表结构
     */
    public function actionCreateTable($tableName, $primaryKey='id')
    {
        $migration = new Migration();

        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $migration->createTable($tableName, [
            $primaryKey => $migration->primaryKey(),
            // The fields here should be add in other DB tools.
            'status' => $migration->tinyInteger()->notNull()->defaultValue(0)->comment('状态|0:无效,1:有效'),
            'create_time' => $migration->dateTime()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_time' => $migration->dateTime()->notNull()->defaultValue(0)->comment('修改时间'),
        ], $tableOptions);
    }

    /**
     * TODO: 初始化数据表
     * @param $flag
     */
    public function actionInit($flag='')
    {
        $reset = false;
        if ($flag == 'reset')
        {
            $reset = true;
        }
    }

    /**
     * @param $deviceKey
     * @param $typeKey
     * @return bool
     */
    public function actionCreateDeviceDataTable($deviceKey, $typeKey)
    {
        if (DeviceDataService::createDeviceDataTables($deviceKey, $typeKey)) {

        } else {

        }
    }


}
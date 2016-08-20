<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/20
 * Time: 23:34
 */

namespace console\controllers;

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
            'status' => $migration->tinyInteger()->notNull()->defaultValue(0),
            'create_time' => $migration->dateTime()->notNull()->defaultValue(0),
            'update_time' => $migration->dateTime()->notNull()->defaultValue(0),
        ], $tableOptions);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/11
 * Time: 22:49
 */

namespace common\services;


use common\models\NucTask;

class TaskService
{
    public static function getTasks()
    {
        //
        return NucTask::find()->where([])->asArray()->all();
    }

    /**
     * @param $taskId
     * @return array|NucTask|null
     */
    public static function getTaskById($taskId)
    {
        $task = NucTask::find()
            ->where(['task_id' => $taskId])
            ->asArray()
            ->one();
        return $task;
    }

}
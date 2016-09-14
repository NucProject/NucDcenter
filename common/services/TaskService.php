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
    /**
     * @param $data
     * @return array|NucTask
     */
    public static function create($data)
    {
        $task = new NucTask();
        $task->setAttribute($data);
        if ($task->save()) {
            return $task;
        } else {
            return $task->getErrors();
        }
    }

    public static function getTasks()
    {
        //
        return NucTask::find()->where([])->asArray()->all();
    }

    /**
     * @param $taskId
     * @return NucTask
     */
    public static function getTaskById($taskId)
    {
        $task = NucTask::findOne($taskId);

        return $task;
    }

}
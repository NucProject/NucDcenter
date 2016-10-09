<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/11
 * Time: 22:49
 */

namespace common\services;


use common\components\ModelSaveFailedException;
use common\components\ResourceNotFoundException;
use common\models\NucTask;
use common\models\NucTaskAttend;

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

    public static function getTasksByDevice($deviceKey)
    {
        return NucTaskAttend::find()
            ->with('task')
            ->where(['device_key' => $deviceKey])
            ->asArray()
            ->all();
    }

    /**
     * @param $taskId
     * @return NucTask
     */
    public static function getTaskById($taskId)
    {
        $task = NucTask::findOne($taskId);
        if ($task)
        {
            $attends = NucTaskAttend::find()
                ->where(['task_id' => $taskId])
                ->with('device')
                ->asArray()
                ->all();

            $task = $task->toArray();
            $task['attends'] = $attends;
        }


        return $task;
    }

    /**
     * @param $deviceKey
     * @param $taskId
     * @return NucTaskAttend
     * @throws
     * 加入一个任务
     */
    public static function attendTask($deviceKey, $taskId)
    {
        $task = NucTask::findOne($taskId);
        if (!$task) {
            throw new ResourceNotFoundException("TaskId=$taskId Not found");
        }

        $attend = NucTaskAttend::find()
            ->where(['task_id' => $taskId, 'device_key' => $deviceKey])
            ->one();

        if ($attend)
        {
            return $attend;
        }

        $attend = new NucTaskAttend();

        $attend->task_id = $taskId;
        $attend->device_key = $deviceKey;
        if ($attend->save()) {
            return $attend;
        } else {
            throw new ModelSaveFailedException($attend->getErrors());
        }
    }

    /**
     * @param $deviceKey
     * @return NucTaskAttend
     * @throws
     * 返回设备最后一次Attend的任务
     */
    public static function getAttendTask($deviceKey)
    {
        $attend = NucTaskAttend::find()
            ->with('task')
            ->where(['device_key' => $deviceKey])
            ->orderBy('attend_id desc')
            ->one();

        if ($attend)
        {
            return $attend;
        }
        return false;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 9:46
 */

namespace frontend\controllers;

use common\services\TaskService;


/**
 *
 * Class MovableController
 * @package frontend\controllers
 */
class MovableController extends BaseMovableController
{
    /**
     * @m.page
     */
    public function actionSignIn()
    {
        // TODO:
    }

    /**
     * @m.api
     * @return string
     * 任务列表
     */
    public function actionTasks()
    {
        $tasks = TaskService::getTasks();
        return parent::result($tasks);
    }

    /**
     * @m.api
     * @param $taskId
     * @return string
     * 任务详情
     */
    public function actionTask($taskId)
    {
        $task = TaskService::getTaskById($taskId);

        return parent::result($task);
    }

    /**
     * @m.api
     * @param $taskId
     * @return string
     */
    public function actionTaskStatus($taskId)
    {
        $task = TaskService::getTaskById($taskId);

        return parent::result($task);
    }

    /**
     * @m.api
     * @param $deviceKey
     * @param $taskId
     * @return json
     * 参与一个任务
     */
    public function actionAttend($deviceKey, $taskId)
    {
        try {
            $attend = TaskService::attendTask($deviceKey, $taskId);

            return parent::result($attend->toArray());
        } catch (\Exception $e) {
            return parent::error(
                [
                    'msg' => "Device($deviceKey) can not join task($taskId)",
                    'exception' => $e
                ],
                1);
        }
    }

    /**
     * @m.api
     * @param $deviceKey
     * @return json
     * 我当前正在参与的任务
     */
    public function actionMyAttend($deviceKey)
    {
        try {
            $attend = TaskService::getAttendTask($deviceKey);
            $task = null;
            if ($attend->task)
            {
                $task = $attend->task->toArray();
            }
            $attend = $attend->toArray();

            return parent::result([
                'attend' => $attend,
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return parent::error([
                    'msg' => "",
                    'exception' => $e
                ],
                1);
        }
    }

}
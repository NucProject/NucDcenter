<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 9:46
 */

namespace frontend\controllers;

use common\services\TaskService;
use yii\web\Controller;

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

    }

    /**
     * @m.api
     * @return string
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


}
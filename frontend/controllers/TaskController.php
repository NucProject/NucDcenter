<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/11
 * Time: 9:23
 */

namespace frontend\controllers;


use common\components\BadArgumentException;
use common\models\NucTask;
use common\services\TaskService;

class TaskController extends BaseController
{
    /**
     * @page
     * @comment 任务列表
     */
    public function actionIndex()
    {
        $data = [];

        $tasks = TaskService::getTasks();

        $runningTasks = [];
        $waitingTasks = [];
        $historyTasks = [];
        foreach ($tasks as $task)
        {
            if ($task['task_status'] == 1) {
                $waitingTasks[] = $task;
            } elseif ($task['task_status'] == 2) {
                $runningTasks[] = $task;
            } elseif ($task['task_status'] == 3) {
                $historyTasks[] = $task;
            }
        }

        $data['runningTasks'] = $runningTasks;
        $data['waitingTasks'] = $waitingTasks;
        $data['historyTasks'] = $historyTasks;

        if ($this->checkHasCreateTaskPermission())
        {
            $data['hasCreateTaskPermission'] = true;
        }

        parent::setBreadcrumbs(['index.html' => '任务']);
        return parent::renderPage('index.tpl', $data, []);
    }

    public function actionCreate()
    {
        $data = [];
        $taskId = 0;

        parent::setBreadcrumbs(['index.html' => '新建任务']);
        return parent::renderPage('create.tpl', $data, ['with' => ['dialog', 'laydate', 'baiduMap']]);
    }

    public function actionDoCreate()
    {
        $taskId = 0;


    }

    public function actionDetail($taskId)
    {
        $task = $this->getTaskById($taskId);
        $data = [
            'task' => $task
        ];

        parent::setBreadcrumbs(['index.html' => '新建任务']);
        return parent::renderPage('detail.tpl', $data, ['with' => ['laydate']]);
    }

    /**
     * @ajax
     * @comment 正式开始一个任务
     */
    public function actionLaunch()
    {

    }

    /**
     * @ajax
     * @comment 任务状态+设备参与状态
     */
    public function actionStatus()
    {
        // TODO: Attend devices?

        // Task status?
    }

    /**
     * @return bool
     */
    private function checkHasCreateTaskPermission()
    {
        return true;
    }

    /**
     * @param $taskId
     * @return mixed
     * @throws BadArgumentException
     */
    private function getTaskById($taskId)
    {
        $task = TaskService::getTaskById($taskId);
        if (!$task) {
            throw new BadArgumentException("Task (task_id=$taskId) Not Found!");
        }
        return $task;
    }
}
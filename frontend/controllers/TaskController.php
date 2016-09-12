<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/11
 * Time: 9:23
 */

namespace frontend\controllers;


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

        $runningTasks = ["地图图片"];
        $waitingTasks = ["地图图片"];
        $historyTasks = [];
        foreach ($tasks as $task)
        {

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
        return parent::renderPage('create.tpl', $data, ['with' => ['laydate']]);
    }

    public function actionDoCreate()
    {
        $taskId = 0;


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
}
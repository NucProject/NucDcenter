<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/11
 * Time: 9:23
 */

namespace frontend\controllers;

use yii;
use common\components\BadArgumentException;
use common\components\Helper;
use common\components\ModelSaveFailedException;
use common\models\NucTask;
use common\models\NucTaskAttend;
use common\services\DeviceDataService;
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

        // $historyTasksCount = count($historyTasks);
        parent::setPageMessage("任务管理列表");
        parent::setBreadcrumbs(['#' => '任务']);
        return parent::renderPage('index.tpl', $data, []);
    }

    /**
     * @page
     * @comment 新建任务
     * @return string
     */
    public function actionCreate()
    {
        $data = [];
        $taskId = 0;

        parent::setBreadcrumbs(['index.html' => '新建任务']);
        return parent::renderPage('create.tpl', $data, ['with' => ['dialog', 'laydate', 'baiduMap']]);
    }

    /**
     * @ajax
     * @return bool
     * @throws BadArgumentException
     *
     */
    public function actionDoCreate()
    {
        $data = [
            'task_name'     => Helper::getPost('taskName', ['required' => true]),
            'task_desc'     => Helper::getPost('taskDesc', ['default' => '']),
            'task_image'    => Helper::getPost('taskImage', ['default' => '']),
            'map_zoom'      => Helper::getPost('map_zoom', ['default' => '11']),
            'lng'           => Helper::getPost('lng', ['default' => '0.0']),
            'lat'           => Helper::getPost('lat', ['default' => '0.0']),
            'begin_set_time'    => Helper::getPost('begin_time', ['default' => '0']),
            'end_set_time'      => Helper::getPost('end_time', ['default' => '0']),
        ];

        $task = TaskService::create($data);
        if (!($task instanceof NucTask)) {
            return parent::error($task, -1);
        }

        $this->redirect(['task/index']);
    }

    /**
     * @page
     * @comment 任务详情
     * @param $taskId
     * @return string
     * @throws BadArgumentException
     */
    public function actionDetail($taskId)
    {
        $task = $this->getTaskById($taskId);

        $data = [
            'task' => $task,
            'fetchValUrl' => 'index.php?r=device-data/latest'
        ];

        parent::setPageMessage($task['task_name']);

        parent::setBreadcrumbs(['index.html' => '任务详情']);
        return parent::renderPage('detail.tpl', $data, ['with' => ['laydate', 'dialog']]);
    }

    /**
     * @ajax
     * @param $taskId
     * @comment 正式开始一个任务
     */
    public function actionStart($taskId)
    {
        TaskService::changeTaskStatus($taskId, TaskService::TaskRunning);

        $this->redirect(array('task/detail', 'taskId' => $taskId));
    }

    /**
     * @ajax
     * @param $taskId
     * @comment 结束一个任务
     */
    public function actionStop($taskId)
    {
        TaskService::changeTaskStatus($taskId, TaskService::TaskCompleted);

        $this->redirect(array('task/detail', 'taskId' => $taskId));
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

    public function actionDelete()
    {
        $taskId = Yii::$app->request->post('taskId');
        if ($taskId) {
            if (TaskService::deleteTask($taskId)) {
                return parent::result(['deleted' => true]);
            }
        }
        return parent::error(['deleted' => false], 1);
    }

    /**
     * @page
     * @comment 辐射分布图
     * @param $taskId int
     * @return string
     */
    public function actionDistribute($taskId)
    {
        $task = $this->getTaskById($taskId);

        $attends = $task['attends'];
        $centerPoint = false;
        $points = false;
        $deviceKeys = [];
        $deviceDataMap = [];
        foreach ($attends as $attend)
        {
            $deviceKey = $attend['device_key'];
            if (!$deviceKey) {
                continue;
            }
            $deviceKeys[] = $deviceKey;

            $deviceDataItems = DeviceDataService::getTaskData($deviceKey, $taskId);

            if (!$centerPoint)
            {
                $deviceDataItem = $deviceDataItems[0];
                $centerPoint = [
                    'lng' => $deviceDataItem['lng'],
                    'lat' => $deviceDataItem['lat']
                ];
            }

            if (!$points) {
                $points = json_encode(self::convertToHeatmapPoints($deviceDataItems, 'inner_doserate'));
            }
            $deviceDataMap[$deviceKey] = json_encode(self::convertToHeatmapPoints($deviceDataItems, 'inner_doserate'));
        }

        // var_dump($centerPoint);exit;
        $data = [
            'task'      => $task,
            'dataMap'   => $deviceDataMap,
            'centerLng' => $centerPoint['lng'],
            'centerLat' => $centerPoint['lat'],
            'deviceKeys' => $deviceKeys,
            'deviceDataMap' => $deviceDataMap
        ];

        parent::setPageMessage('区域辐射分布图');
        parent::setBreadcrumbs(['index.php?r=task' => '任务', '#' => '辐射分布']);
        return parent::renderPage('doserate-grid.tpl', $data, ['with' => ['laydate', 'baiduMap', 'Mapgrid', 'Slim']]);
    }

    /**
     * @page
     * @comment 任务回放
     * @param $taskId int
     * @return string
     */
    public function actionReplay($taskId)
    {
        $task = $this->getTaskById($taskId);

        $attends = $task['attends'];
        $centerPoint = false;
        $points = false;
        $deviceKeys = [];
        $deviceDataMap = [];
        foreach ($attends as $attend)
        {
            $deviceKey = $attend['device_key'];
            if (!$deviceKey) {
                continue;
            }
            $deviceKeys[] = $deviceKey;

            $deviceDataItems = DeviceDataService::getTaskData($deviceKey, $taskId);

            if (!$centerPoint)
            {
                $deviceDataItem = $deviceDataItems[0];
                $centerPoint = [
                    'lng' => $deviceDataItem['lng'],
                    'lat' => $deviceDataItem['lat']
                ];
            }

            if (!$points) {
                $points = json_encode(self::convertToHeatmapPoints($deviceDataItems, 'inner_doserate'));
            }
            $deviceDataMap[$deviceKey] = json_encode(self::convertToHeatmapPoints($deviceDataItems, 'inner_doserate'));
        }

        // var_dump($centerPoint);exit;
        $data = [
            'task'      => $task,
            'dataMap'   => $deviceDataMap,
            'centerLng' => $centerPoint['lng'],
            'centerLat' => $centerPoint['lat'],
            'deviceKeys' => $deviceKeys,
            'deviceDataMap' => $deviceDataMap
        ];


        parent::setBreadcrumbs(['index.php?r=task' => '任务', '#' => '轨迹回放']);
        return parent::renderPage('replay.tpl', $data, ['with' => ['laydate', 'baiduMap', 'Heatmap']]);
    }

    /**
     * @return string
     */
    public function actionMap()
    {
        $data = [];

        parent::setBreadcrumbs(['index.php?r=task' => '任务', '#' => '地图数据生成']);
        return parent::renderPage('map.tpl', $data, ['with' => ['laydate', 'baiduMap', 'Heatmap']]);
    }


    /**
     * @return bool
     */
    private function checkHasCreateTaskPermission()
    {
        return true;
    }

    /**
     * @param $data
     * @param $field
     * @return array
     */
    private static function convertToHeatmapPoints($data, $field)
    {
        $results = [];
        foreach ($data as $item)
        {
            $count = $item[$field];
            $results[] = ['lng' => $item['lng'],
                          'lat' => $item['lat'],
                          'count' => $count,
                          'data_time' => $item['data_time']];
        }
        return $results;
    }

    /**
     * @param $taskId
     * @return NucTask
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
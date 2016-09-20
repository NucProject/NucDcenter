<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/11
 * Time: 9:23
 */

namespace frontend\controllers;


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
        $now = time();

        $data = [
            'task_name' => Helper::getPost('taskName', ['required' => true]),
            'lng' => Helper::getPost('lng', []),
            'lat' => Helper::getPost('lat', []),
        ];

        $png = md5($data['task_name']) . "_{$now}.png";
        Helper::saveBaiduMapRectByPoint($png, $data['lng'], $data['lat']);

        $task = TaskService::create($data);
        if (!($task instanceof NucTask)) {
            return parent::error($task, -1);
        }
        return parent::result($task);
    }

    public function actionDetail($taskId)
    {
        $task = $this->getTaskById($taskId);

        $data = [
            'task' => $task
        ];

        if ($task['task_status'] == 1) {
            parent::setPageMessage("任务即将于{$task['begin_set_time']}开始");
        } elseif ($task['task_status'] == 2) {
            parent::setPageMessage("任务正在进行中...");
        } elseif ($task['task_status'] == 3) {
            parent::setPageMessage("任务已结束", "{$task['begin_time']}~{$task['end_time']}");
        }

        parent::setBreadcrumbs(['index.html' => '任务详情']);
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
     * @page
     * @comment 轨迹回放
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

        // var_dump($deviceDataMap);exit;

        parent::setBreadcrumbs(['index.html' => '任务', '#' => '轨迹回放']);
        return parent::renderPage('replay.tpl', $data, ['with' => ['laydate', 'baiduMap', 'Heatmap']]);
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
            $count = intval($item[$field] / 10);
            $results[] = ['lng' => $item['lng'], 'lat' => $item['lat'], 'count' => $count];
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
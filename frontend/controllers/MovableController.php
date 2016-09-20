<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 9:46
 */

namespace frontend\controllers;

use yii\web\Controller;

/**
 * 移动设备访问的N个页面, 目前涉及到的页面比较少, 暂时按照Movable的维度划分
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
     * @m.page
     */
    public function actionTaskList()
    {

    }

    /**
     * @m.page
     * @param $taskId
     */
    public function actionTask($taskId)
    {

    }

    /**
     * @ajax
     * @param $taskId
     */
    public function actionTaskStatus($taskId)
    {

    }

    /**
     * @ajax
     * @param $taskId
     * @return json
     */
    public function actionAttend($taskId)
    {


        return parent::result([]);
    }


}
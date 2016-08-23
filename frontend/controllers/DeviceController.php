<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/23
 * Time: 20:10
 */

namespace frontend\controllers;


class DeviceController extends BaseController
{

    public function actionDataList($deviceKey)
    {
        $data['data'] = $this->getDeviceData($deviceKey);
        return parent::renderPage('list.tpl', $data);
    }

    public function actionDataChart($deviceKey)
    {
        $data['data'] = $this->getDeviceData($deviceKey);
        return parent::renderPage('chart.tpl', $data);
    }

    /**
     * @param $deviceKey
     * @return array
     */
    private function getDeviceData($deviceKey)
    {
        return [];
    }
}
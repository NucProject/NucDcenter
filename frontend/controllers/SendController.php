<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/26
 * Time: 22:30
 */

namespace frontend\controllers;

use yii;

class SendController extends BaseController
{
    const CommonData = 1;
    const MobileData = 2;

    /**
     * @POST send/data
     */
    public function actionData()
    {
        $this->dataHandler(self::CommonData);
    }

    /**
     * @POST send/mobile-data
     */
    public function actionMobileData()
    {
        $this->dataHandler(self::MobileData);
    }

    /**
     * @param $type int const
     * @return bool
     */
    private function dataHandler($type) {

        $request = Yii::app()->request;
        if (!$request->isPost()) {
            return parent::error(['msg' => 'Post required'], 1);
        }
        $payload = $request->getRawBody();
        $post = @json_decode($payload, true);
        if (!$post) {
            return parent::error(['msg' => 'Bad Post'], 2);
        }

        if (!array_key_exists('time', $post)) {
            return parent::error(['msg' => 'Data-time lost'], 3);
        }
        $time = $post['time'];
        file_put_contents("d:\\sends\\$time.txt", $payload . "\n");

        if ($this->saveDeviceData($post, $time, $type)) {
            return parent::result(['msg' => 'Saved OK!']);
        } else {
            return parent::error(['msg' => 'Save failed!'], 4);
        }
    }

    /**
     * @param $data array
     * @param $time string datetime
     * @param $type int const
     * @return bool
     */
    private function saveDeviceData($data, $time, $type) {

        $deviceKey = $data['deviceKey'];

        //
        //
        //
        //if ($type == self::MobileData) {
        //    $ret = PreAppWorkDevice::getDeviceId($deviceSn);
        //    $deviceId = $ret[0];
        //    $stationId = $ret[1];
        //} elseif ($type == self::CommonData) {
        //    $ret = PreAppDevice::getDeviceId($deviceSn);
        //    $deviceId = $ret[0];
        //    $stationId = $ret[1];
        //}
        //
        //$values = $data['values'];
        //foreach ($values as $value) {
        //    $sensorName = $value['sensor']; // name or sensor?
        //    $sensorValue = $value['value'];
        //
        //    if ($type == 'work') {
        //        $sensorId = PreAppWorkSensor::getSensorId($deviceId, $sensorName);
        //        // echo "($sensorName-$sensorId)";
        //        $dataObj = new WorkDeviceData();
        //        $dataObj->set($deviceId, $sensorId, $stationId);
        //        $dataObj->setLocation($data['Lat'], $data['Lng'], $data['Lat_gps'], $data['Lng_gps']);
        //    } else {
        //        $sensorId = PreAppSensor::getSensorId($deviceId, $sensorName);
        //        $dataObj = new DeviceData();
        //        $dataObj->set($deviceId, $sensorId, $stationId);
        //    }
        //
        //    $dataObj->dateline = strtotime($time);
        //    $dataObj->data = $sensorValue;
        //    $result = $dataObj->save();
        //    if (!$result) {
        //        var_dump($dataObj->getMessages());
        //    }
        //}
        //
        //return true;
    }

    /**
     * @param $data array
     * @param $time string datetime
     * @param $type int const
     * 保持数据到Redis
     * @return bool
     */
    private function cacheDeviceData($data, $time, $type)
    {

    }

    /**
     * @param $data array
     * @param $time string datetime
     * @param $type int const
     * 保持数据到MySQL
     * @return bool
     */
    private function persistDeviceData($data, $time, $type)
    {

    }
}
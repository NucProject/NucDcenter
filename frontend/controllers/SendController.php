<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/26
 * Time: 22:30
 */

namespace frontend\controllers;

use common\services\DataCenterService;
use common\services\DeviceDataService;
use common\services\EntityIdService;
use common\services\handlers\FileHandler;
use yii;

/**
 * Class SendController
 * @package frontend\controllers
 */
class SendController extends BaseController
{
    const CommonData = 1;

    const MobileData = 2;

    public $enableCsrfValidation = false;

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

    public function actionFile()
    {
        $this->fileHandler();
    }

    /**
     *
     * 自动站状态更新数据接收并处理
     */
    public function actionStationStatus()
    {
        // TODO: Update station status
    }

    /**
     * @param $type int const
     * @return bool
     */
    private function dataHandler($type)
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return parent::error(['msg' => 'Post required'], 1);
        }
        $payload = $request->getRawBody();
        $ts = time();
        if (isset(Yii::$app->params['recordSends']) && Yii::$app->params['recordSends'])
        {
            file_put_contents("D:\\NucProject\\sends\\{$type}-{$ts}.txt", $payload);
        }

        $post = @json_decode($payload, true);
        if (!$post) {
            return parent::error(['msg' => 'Bad Post'], 2);
        }

        // Handle 北京站原来的数据结构
        if (array_key_exists('entry', $post)) {
            $post = $this->convertFromEntry($post);
        }

        if (!array_key_exists('data_time', $post)) {
            return parent::error(['msg' => 'Data-time lost'], 3);
        }
        $time = $post['data_time'];

        if ($this->saveDeviceData($post, $time, $type)) {
            return parent::result(['msg' => 'Saved OK!']);
        } else {
            return parent::error(['msg' => 'Save failed!'], 4);
        }
    }

    /**
     * @param $data     array
     * @param $dataTime string datetime
     * @param $type int const
     * @return bool
     */
    private function saveDeviceData($data, $dataTime, $type) {

        $deviceSn = $data['device_sn'];
        $centerId = DataCenterService::deployedCenterId();

        if (!$deviceSn) {
            return false;
        }

        $deviceKey = EntityIdService::genDeviceKey($centerId, $deviceSn);
        if (!stristr($deviceKey, 'dk')) {
            // DeviceKey should starts-with 'dk'
            return false;
        }

        DeviceDataService::addEntry($deviceKey, $dataTime, $data);
        return true;
    }

    /**
     * @param $deviceKey
     * @param $data array
     * @param $time string datetime
     * @param $type int const
     * 保持数据到Redis
     * @return bool
     */
    private function cacheDeviceData($deviceKey, $data, $time, $type)
    {

    }

    /**
     * @param $deviceKey
     * @param $data array
     * @param $time string datetime
     * @param $type int const
     * 保持数据到MySQL
     * @return bool
     */
    private function persistDeviceData($deviceKey, $data, $time, $type)
    {

    }

    private function fileHandler()
    {
        // Set name as file for upload file from C# WebClient.UploadFile
        $file = yii\web\UploadedFile::getInstanceByName("file");

        $fileType = Yii::$app->request->get('fileType');
        if (!$fileType) {
            // TODO: Error handlers
        }

        $handler = FileHandler::getHandler($fileType);
        if ($handler) {
            $handler->save($file);
        }


    }

    private function convertFromEntry($post)
    {
        return $post;
    }
}
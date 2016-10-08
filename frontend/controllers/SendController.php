<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/26
 * Time: 22:30
 */

namespace frontend\controllers;

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
        // file_put_contents("d:\\sends\\{$ts}.txt", $payload);

        $post = @json_decode($payload, true);
        if (!$post) {
            return parent::error(['msg' => 'Bad Post'], 2);
        }

        if (!array_key_exists('time', $post)) {
            return parent::error(['msg' => 'Data-time lost'], 3);
        }
        $time = $post['time'];

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
        if (!stristr($deviceKey, 'DK')) {
            // Invalid Device-Key!
            return false;
        }


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
}
<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 9:55
 *
 */

namespace frontend\controllers;

use yii;
use common\components\BadArgumentException;
use common\components\Helper;
use common\services\DeviceTypeService;

class DeviceTypeController extends BaseController
{
    /**
     * @page
     * @comment
     */
    public function actionIndex()
    {
        $data = [];
        $data['deviceTypes'] = DeviceTypeService::getDeviceTypeList();

        parent::setPageMessage("自动站支持的全部设备类型");
        parent::setBreadcrumbs(['#' => '设备类型列表']);
        return parent::renderPage('index.tpl', $data, []);
    }

    /**
     * @page
     * @comment
     */
    public function actionAdd()
    {
        $data = [
            'doUpdateUrl' => 'index.php?r=device-type/do-add',
            'addNew'      => true,
            'fields'      => []
        ];

        parent::setPageMessage("增加一种新的设备类型");
        parent::setBreadcrumbs(['index.php?device-type' => '设备类型列表', '#' => '新增']);
        return parent::renderPage('add.tpl', $data, []);
    }

    /**
     * @api
     * @comment
     */
    public function actionDoAdd()
    {
        $params = [
            'type_key' => Helper::getPost('typeKey', ['required' => true])
        ];

        if (DeviceTypeService::createDeviceType($params)) {

        }
    }

    /**
     * @page
     * @comment
     */
    public function actionModify()
    {
        $data = ['doUpdateUrl' => 'index.php?r=device-type/do-modify'];
        //
        return parent::renderPage('add.tpl', $data, []);
    }

    /**
     * @api
     * @comment
     */
    public function actionDoModify()
    {

    }

    /**
     * @api
     * @comment
     */
    public function actionDisable()
    {

    }

    public function actionView()
    {
        $typeKey = Yii::$app->request->get('typeKey');
        if (!$typeKey) {
            throw new BadArgumentException('Invalid typeKey');
        }

        // TODO: Type info

        // TODO: Type Fields info

    }

    /**
     * @param $typeKey
     * @return bool
     */
    public function actionInfo($typeKey)
    {
        $deviceType = DeviceTypeService::getDeviceType($typeKey);
        if ($deviceType)
        {
            $deviceType = $deviceType->toArray();
            return parent::result(['typeKey' => $typeKey, 'deviceType' => $deviceType]);
        }
        return parent::error(['msg' => "No device type type-key=>{$typeKey}"], -1);

    }
}
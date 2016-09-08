<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 9:55
 *
 */

namespace frontend\controllers;


use common\components\Helper;
use common\components\ModelSaveFailedException;
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
        return parent::renderPage('index.tpl', $data, []);
    }

    /**
     * @page
     * @comment
     */
    public function actionAdd()
    {
        $data = ['doAddUrl' => 'index.php?r=device-type/do-add'];
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
}
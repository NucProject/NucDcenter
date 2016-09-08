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
            'addNew' => true
        ];
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
        // 此处用一个tpl, 代码复用.
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
}
<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 9:55
 *
 */

namespace frontend\controllers;

use common\models\NucDeviceType;
use yii;
use common\components\BadArgumentException;
use common\components\Helper;
use common\services\DeviceTypeService;

class DeviceTypeController extends BaseController
{
    /**
     * @page
     * @comment 设备类型列表
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
     * @comment 添加新的设备类型
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
        return parent::renderPage('add.tpl', $data, ['with' => ['dialog']]);
    }

    /**
     * @ajax
     * @comment
     */
    public function actionDoAdd()
    {
        $params = [
            'type_key' => Helper::getPost('typeKey', ['required' => true]),
            'type_name' => Helper::getPost('typeName', ['required' => true]),
            'type_desc' => Helper::getPost('typeDesc', ['required' => false, 'default' => '']),

            'is_movable' => Helper::getPost('isMovable', ['required' => true]),
            'type_pic' => Helper::getPost('typePic', ['required' => false, 'default' => '']),
        ];

        $fields = Yii::$app->request->post('fields');
        if (DeviceTypeService::createDeviceType($params, $fields)) {

        }

        return parent::result(Yii::$app->request->post());
    }

    /**
     * @page
     * @comment 设备类型修改
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
     * @ajax
     * @comment
     */
    public function actionDisable()
    {

    }

    /**
     * @page
     * @comment 设备类型详情
     * @throws BadArgumentException
     */
    public function actionView()
    {
        $typeKey = Yii::$app->request->get('typeKey');
        if (!$typeKey) {
            throw new BadArgumentException('Invalid typeKey');
        }

        $type = NucDeviceType:: find()
            ->with('fields')->where(['type_key' => $typeKey])->asArray()->one();

        $data = [
            'type' => $type
        ];

        parent::setBreadcrumbs(['/index.php?r=device-type/index' => '设备类型列表', '#' => '设备类型查看']);
        return parent::renderPage('view.tpl', $data, []);
    }

    /**
     * @page
     * @comment 设备类型详情2
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
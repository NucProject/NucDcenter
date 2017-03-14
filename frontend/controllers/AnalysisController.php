<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2017/2/27
 * Time: 20:38
 */

namespace frontend\controllers;


class AnalysisController extends BaseController
{
    /**
     * @page
     * @comment 特征核素数据分析
     * @return string
     */
    public function actionCinderella()
    {
        $data = [];
        // TODO: 如果有多个Cinderella怎么办? 跳转到一个设备列表页面, 然后再回到这个页面好了?

        parent::setPageMessage('征核素数据分析');
        parent::setBreadcrumbs(['index.html' => '设备', '#' => '特征核素数据分析']);
        return parent::renderPage('cinderella_data_analysis.tpl', $data, ['with' => ['dialog', 'echarts']]);
    }

    /**
     * @page
     * @comment 特征核素设备列表
     * @return string
     */
    public function actionCinderellaDevices()
    {
        $data = [];
        // 设备列表

        parent::setPageMessage('特征核素设备列表');
        parent::setBreadcrumbs(['index.html' => '设备', '#' => '特征核素设备列表']);
        return parent::renderPage('cinderella_devices.tpl', $data, ['with' => ['dialog', 'echarts']]);
    }
}
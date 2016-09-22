<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/30
 * Time: 12:49
 */

namespace common\components;

use \yii\web\View;

trait StaticFiles
{
    private $depends = [View::POS_END, 'depends' => 'frontend\assets\AppAsset'];

    public function addWebUploader($view)
    {
        $view->registerCssFile('webuploader/webuploader.css');
        $view->registerJsFile('webuploader/webuploader.js', [View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addDialog($view)
    {
        $view->registerJsFile('js/bootbox/bootbox.min.js', [View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addDatePicker($view)
    {
        $view->registerCssFile('js/datepicker/themes/default.min.css');
        $view->registerJsFile('js/datepicker/picker.js', [\yii\web\View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addLaydate($view)
    {
        $view->registerJsFile('js/laydate/laydate.js', [View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addBaiduMap($view)
    {
        $ak = \Yii::$app->params['baiduMapAk'];
        $view->registerJsFile('http://api.map.baidu.com/api?v=2.0&ak=' . $ak, [View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addEcharts($view)
    {
        $view->registerJsFile('js/echarts/echarts.min.js', [View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addHeatmap($view)
    {
        // TODO: Heatmap.min.js has Error!
        $view->registerJsFile('js/Heatmap/Heatmap.js', [View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addMapgrid($view)
    {
        // TODO: Heatmap.min.js has Error!
        $view->registerJsFile('js/Mapgrid/mapgrid.js', [View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

}
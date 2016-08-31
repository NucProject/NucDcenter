<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/30
 * Time: 12:49
 */

namespace common\components;


trait StaticFiles
{
    public function addWebUploader($view)
    {
        $view->registerCssFile('webuploader/webuploader.css');
        $view->registerJsFile('webuploader/webuploader.js', [\yii\web\View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addDialog($view)
    {
        $view->registerJsFile('js/bootbox/bootbox.min.js', [\yii\web\View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addDatePicker($view)
    {
        $view->registerCssFile('js/datepicker/themes/default.min.css');
        $view->registerJsFile('js/datepicker/picker.js', [\yii\web\View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addLaydate($view)
    {
        $view->registerJsFile('js/laydate/laydate.js', [\yii\web\View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }
}
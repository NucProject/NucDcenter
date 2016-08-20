<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/19
 * Time: 20:01
 */

namespace frontend\controllers;

use yii;
use yii\web\Controller;
use frontend\assets\AppAsset as AppAsset3;

class BaseController extends Controller
{
    // All controllers extents BaseController use this Layout file!
    // TODO: How to AppAsset::register($this); ?
    public $layout = 'main-layout.tpl';

    /**
     * @param $page
     * @param $data
     * @return string
     * 基类会处理一些模板中公用的部分
     */
    public function renderPage($page, $data=array())
    {
        $this->on(yii\base\View::EVENT_BEFORE_RENDER, [$this, 'viewBeforeRender']);

        return $this->render($page, $data);
    }

    public function viewBeforeRender($event)
    {
        echo 43;
    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     * overwrite yii\base\Controller's render
     */
    public function render($view, $params = [])
    {
        $content = $this->getView()->render($view, $params, $this);

        return $this->renderContent($content);
    }

    public static function imports() {
        return [
            'StationService' => 'common\services\StationService',
            'DeviceService' => 'common\services\DeviceService'
        ];
    }
}
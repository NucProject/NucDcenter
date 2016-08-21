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
use frontend\assets\AppAsset;

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
        AppAsset::register($this->getView());
        // $this->on(yii\base\View::EVENT_BEFORE_RENDER, [$this, 'viewBeforeRender']);

        // 当前页面.tpl文件对应的.js.tpl文件
        $data['currentPageJsFile'] = self::getPageJsFileName($page);

        return $this->render($page, $data);
    }

    // Can't receive the Event, now.
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

        return $this->renderContentInLayout($content, $params);
    }

    /**
     * In fact, This equals Controller::renderContent($content), And I add $params
     * Renders a static string by applying a layout.
     * @param string $content the static string being rendered
     * @param array $params Merge tpl-view's params into layout, not only $content.
     * @return string the rendering result of the layout with the given static string as the `$content` variable.
     * If the layout is disabled, the string will be returned back.
     * @since 2.0.1
     */
    private function renderContentInLayout($content, $params)
    {
        $layoutFile = $this->findLayoutFile($this->getView());
        if ($layoutFile !== false) {
            $params['content'] = $content;
            return $this->getView()->renderFile($layoutFile, $params, $this);
        } else {
            return $content;
        }
    }

    public static function imports() {
        return [
            'StationService' => 'common\services\StationService',
            'DeviceService' => 'common\services\DeviceService'
        ];
    }

    private static function getPageJsFileName($page)
    {
        return substr($page, 0, -4) . '.js.tpl';
    }
}
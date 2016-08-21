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
use common\services\DcenterService;

class BaseController extends Controller
{
    // All controllers extents BaseController use this Layout file!
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

        $data['theDeployedCenterId'] = DcenterService::deployedCenterId();

        if (!isset($data['pageTitle'])) {
            $data['pageTitle'] = DcenterService::defaultPageTitle();
        }

        // Event
        // $this->getView()->on(yii\base\View::EVENT_BEFORE_RENDER, [$this, 'viewBeforeRender']);

        // 当前页面.tpl文件对应的.js.tpl文件
        $data['currentPageJsFile'] = self::getPageJsFileName($page);

        return $this->render($page, $data);
    }

    /**
     * @param $data
     */
    public static function result($data) {
        static::retVal($data, 0);
    }

    /**
     * @param $data
     * @param $errorCode
     */
    public static function error($data, $errorCode) {
        static::retVal($data, $errorCode);
    }

    private static function retVal($data, $errorCode) {
        exit(json_encode(['error' => $errorCode, 'data' => $data]));
    }

    /**
     * @param $event yii\base\View::EVENT_BEFORE_RENDER
     * @param $handler string | function
     */
    public function registerViewEventHandler($event, $handler)
    {
        if (is_string($handler)) {
            $handler = [$this, $handler];
        }
        $this->getView()->on($event, $handler);
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

        // override return $this->renderContent($content);
        return $this->renderContentInLayout($content, $params);
    }

    /**
     * In fact, This seems Controller::renderContent($content), And I add $params
     * Renders a static string by applying a layout.
     * @param string $content the static string being rendered
     * @param array $params Merge tpl-view's params into layout, not only $content.
     * @return string the rendering result of the layout with the given static string as the `$content` variable.
     * If the layout is disabled, the string will be returned back.
     * @since 2.0.9
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

    /**
     * @return array
     * 提供tpl文件可能使用的classes
     */
    public static function imports() {
        return [
            'StationService' => 'common\services\StationService',
            'DeviceService' => 'common\services\DeviceService'
        ];
    }

    /**
     * @param $page string: It MUST be in format <file-name>.tpl
     * @return string
     */
    private static function getPageJsFileName($page)
    {
        return substr($page, 0, -4) . '.js.tpl';
    }
}
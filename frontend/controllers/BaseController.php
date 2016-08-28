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
use common\services\DataCenterService;

class BaseController extends Controller
{
    // All controllers extents BaseController use this Layout file!
    public $layout = 'main-layout.tpl';

    private $breadcrumbs = [];

    public function behaviors()
    {
        return [
            'access' => [
                'class' => 'common\components\AccessControl',
                'except' => ['something'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manageThing1'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $page
     * @param $data
     * @param $options
     * @return string
     *
     */
    public function renderPage($page, $data, $options=[])
    {
        AppAsset::register($this->getView());

        $data['theDeployedCenterId'] = DataCenterService::deployedCenterId();

        if (!isset($data['pageTitle'])) {
            $data['pageTitle'] = DataCenterService::defaultPageTitle();
        }

        $this->initSideBar($data);

        $this->initBreadcrumbs($data);

        if (isset($options['withDialog']) && $options['withDialog'] == true) {
            $this->addDialog();
        }

        // Event
        // $this->getView()->on(yii\base\View::EVENT_BEFORE_RENDER, [$this, 'viewBeforeRender']);

        //
        $data['currentPageJsFile'] = self::getPageJsFileName($page);

        return $this->render($page, $data);
    }

    /**
     * @param $data
     * @return bool exit() in fact
     */
    public static function result($data) {
        return static::retVal($data, 0);
    }

    /**
     * @param $data
     * @param $errorCode
     * @return bool exit() in fact
     */
    public static function error($data, $errorCode) {
        return static::retVal($data, $errorCode);
    }

    /**
     * @param $data
     * @param $errorCode
     * @return bool exit() in fact
     */
    private static function retVal($data, $errorCode) {
        exit(json_encode(['error' => $errorCode, 'data' => $data]));
        return false;
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

        if ($this->layout) {
            // override return $this->renderContent($content);
            // Render with layout
            return $this->renderContentInLayout($content, $params);
        } else {
            // Render the content only without $this->layout => for null
            return $content;
        }
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
            $params['viewContent'] = $content;
            return $this->getView()->renderFile($layoutFile, $params, $this);
        } else {
            return $content;
        }
    }

    /**
     * @return array
     * load classes in .tpl
     */
    public static function imports() {
        return [
            'StationService' => 'common\services\StationService',
            'DeviceService' => 'common\services\DeviceService',
            'Alert' => 'common\widgets\Alert',
            'Html' => 'yii\helpers\Html'
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

    private function initSideBar(&$data)
    {
        $menuArray = $this->getMenuArrayByUserRole();

        $sidebarMenus = [];
        foreach ($menuArray as $menuItem)
        {
            // MUST have a title
            if (!array_key_exists('title', $menuItem)) {
                continue;
            }

            $menu = ['title' => $menuItem['title'], 'selected' => false];

            if (array_key_exists('selected', $menuItem) && $menuItem['selected']) {
                $menu['selected'] = true;
            }

            if (array_key_exists('badge', $menuItem)) {
                $menu['badge'] = $menuItem['badge'];
            }

            if (array_key_exists('subMenus', $menuItem)) {
                $menu['subMenus'] = $menuItem['subMenus'];
                $menu['href'] = 'javascript:;';
            } else {
                // PHP7 ?? operator CAN shorter this line
                $menu['href'] = isset($menuItem['href']) ? $menuItem['href'] : 'javascript:;';
            }

            $sidebarMenus[] = $menu;
        }

        $data['sidebarMenus'] = $sidebarMenus;
    }

    /**
     * @return array
     * 注意数据结构
     */
    private function getMenuArrayByUserRole()
    {
        $menuArray = [
            ['title' => '自动站管理',  'href' => '404.html', 'badge' => "45"],

            ['title' => '移动设备管理', 'selected' => true,
                'subMenus' => [['href' => '', 'title' => 'jQuery'], ['href' => '', 'title' => 'Bootstrap']]
            ],
        ];
        return $menuArray;
    }

    public function setBreadcrumbs($breadcrumbs)
    {
        // Home
        $this->breadcrumbs[] = array('href' => '', 'title' => '首页', 'home' => true);
        foreach ($breadcrumbs as $href => $title)
        {
            $this->breadcrumbs[] = array('href' => $href, 'title' => $title, 'home' => false);;
        }
    }

    private function initBreadcrumbs(&$data)
    {
        $data['breadcrumbs'] = $this->breadcrumbs;
    }

    public function initWebUploader()
    {
        $view = $this->getView();
        $view->registerCssFile('webuploader/webuploader.css');
        $view->registerJsFile('webuploader/webuploader.js', [\yii\web\View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

    public function addDialog()
    {
        $view = $this->getView();
        $view->registerJsFile('js/bootbox/bootbox.min.js', [\yii\web\View::POS_END, 'depends' => 'frontend\assets\AppAsset']);
    }

}
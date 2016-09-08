<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/4 0:13
 *
 */

namespace frontend\controllers;

use common\components\Helper;
use yii;
use common\services\AdminRoleService;

class AdminRoleController extends BaseController
{
    /**
     * @page
     * @comment 角色列表
     */
    public function actionIndex()
    {
        $data = [];
        $data['roles'] = AdminRoleService::getAdminRoles();

        return parent::renderPage('list.tpl', $data, []);

    }

    /**
     * @page
     * @comment 角色增加
     */
    public function actionAdd()
    {
        $data = [];
        $data['doAddUrl'] = 'index.php?r=admin-role/add';   // [1]
        return parent::renderPage('add.tpl', $data, []);
    }

    /**
     * [1]
     * @ajax
     * @comment 角色增加
     */
    public function actionDoAdd()
    {
        $params = [
            'role_name'    => Helper::getPost('roleName', ['required' => true]),
            'role_desc'    => Helper::getPost('roleDesc', ['default' => '']),
        ];

        if (AdminRoleService::addRole($params))
        {
            Yii::$app->session->setFlash('add-station', 'success');
            Yii::$app->response->redirect('index.php?r=admin-role/index');
        }
    }

    /**
     * @ajax
     * @comment 角色禁用
     */
    public function actionDisable()
    {

    }

    /**
     * @page
     * @comment 角色节点
     */
    public function actionNodes()
    {

    }

    /**
     * @page
     * @comment 角色菜单
     */
    public function actionMenus()
    {

    }

    /**
     * @ajax
     * @comment 角色删除
     */
    public function actionMenusUpdate()
    {

    }
}